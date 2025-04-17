import { person as personLink } from '@/functions';
import App from '@/Layouts/App';
import { Family, PageProps, Person } from '@/types';
import React, { useEffect, useMemo, useRef, useState } from 'react';

const PersonCard = React.memo(function PersonCard({
    person,
}: {
    person: Person | null | undefined;
}) {
    if (!person) return null;
    return (
        <div className="w-52 rounded-2xl bg-gray-50 p-3 text-center shadow-md">
            <div className="text-md font-semibold">{personLink(person)}</div>
            <div className="text-xs text-gray-400">
                {person.birth?.date?.date ? `${person.birth.date.date}` : ''}
                {person.death?.date?.date ? ` - ${person.death.date.date}` : ''}
            </div>
        </div>
    );
});

const FamilyNode = React.memo(function FamilyNode({
    family,
    families,
    level = 0,
    visited = new Set<string>(),
}: {
    family: Family;
    families: { [key: string]: Family };
    level?: number;
    visited?: Set<string>;
}) {
    const branchVisited = new Set(visited);
    if (branchVisited.has(family.id)) {
        return null;
    }
    branchVisited.add(family.id);

    const childFamilies = useMemo(() => {
        return Object.values(families).filter((f) => {
            return family.children.some(
                (child) =>
                    child.id === f.husband?.id || child.id === f.wife?.id,
            );
        });
    }, [families, family.children]);

    const standaloneChildren = useMemo(() => {
        return family.children.filter((child) => {
            return !Object.values(families).some(
                (f) => f.husband?.id === child.id || f.wife?.id === child.id,
            );
        });
    }, [families, family.children]);

    return (
        <div className="flex flex-col items-center">
            <div className="relative flex items-center space-x-6">
                <PersonCard person={family.husband} />
                <PersonCard person={family.wife} />
            </div>

            {(standaloneChildren.length > 0 || childFamilies.length > 0) && (
                <div className="h-6 w-0.5 bg-gray-300"></div>
            )}

            <div className="flex flex-col items-center">
                {standaloneChildren.length > 0 && (
                    <div className="mb-4 flex space-x-4">
                        {standaloneChildren.map((child) => (
                            <PersonCard key={child.id} person={child} />
                        ))}
                    </div>
                )}

                {childFamilies.length > 0 && (
                    <div className="flex space-x-10 pt-4">
                        {childFamilies.map((childFamily) => (
                            <div
                                key={childFamily.id}
                                className="flex flex-col items-center"
                            >
                                <FamilyNode
                                    family={childFamily}
                                    families={families}
                                    level={level + 1}
                                    visited={branchVisited}
                                />
                            </div>
                        ))}
                    </div>
                )}
            </div>
        </div>
    );
});

export default function Tree({
    families,
    people,
}: PageProps<{
    families: { [key: string]: Family };
    people: { [key: string]: Person };
}>) {
    const containerRef = useRef<HTMLDivElement>(null);
    const [isDragging, setIsDragging] = useState(false);
    const [translate, setTranslate] = useState({ x: 0, y: 0 });
    const [scale, setScale] = useState(1);
    const [startPos, setStartPos] = useState({ x: 0, y: 0 });

    const rootFamilies = useMemo(() => {
        return Object.values(families).filter((family) => {
            const isHusbandChild = Object.values(families).some((f) =>
                f.children.some((child) => child.id === family.husband?.id),
            );
            const isWifeChild = Object.values(families).some((f) =>
                f.children.some((child) => child.id === family.wife?.id),
            );
            return !isHusbandChild && !isWifeChild;
        });
    }, [families]);

    // Mouse event handlers for dragging
    const handleMouseDown = (e: React.MouseEvent) => {
        setIsDragging(true);
        setStartPos({ x: e.clientX - translate.x, y: e.clientY - translate.y });
        e.preventDefault();
    };

    const handleMouseMove = (e: MouseEvent) => {
        if (!isDragging) return;
        setTranslate({
            x: e.clientX - startPos.x,
            y: e.clientY - startPos.y,
        });
    };

    const handleMouseUp = () => {
        setIsDragging(false);
    };

    useEffect(() => {
        if (isDragging) {
            document.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', handleMouseUp);
        } else {
            document.removeEventListener('mousemove', handleMouseMove);
            document.removeEventListener('mouseup', handleMouseUp);
        }
        return () => {
            document.removeEventListener('mousemove', handleMouseMove);
            document.removeEventListener('mouseup', handleMouseUp);
        };
    }, [isDragging, startPos]);

    // Zoom handler
    useEffect(() => {
        const handleWheel = (e: WheelEvent) => {
            if (e.ctrlKey) {
                e.preventDefault();
                setScale((prev) => prev - e.deltaY * 0.001);
            }
        };

        const container = containerRef.current;
        container?.addEventListener('wheel', handleWheel, { passive: false });

        return () => {
            container?.removeEventListener('wheel', handleWheel);
        };
    }, []);

    return (
        <App title="tree" full>
            <div
                ref={containerRef}
                className="h-screen w-full cursor-grab select-none overflow-hidden active:cursor-grabbing"
                onMouseDown={handleMouseDown}
            >
                <div
                    className="relative transition-transform duration-100"
                    style={{
                        transform: `translate(${translate.x}px, ${translate.y}px) scale(${scale})`,
                        transformOrigin: 'center center',
                    }}
                >
                    <div className="flex justify-center p-10">
                        <div className="flex space-x-10">
                            {rootFamilies.map((family) => (
                                <FamilyNode
                                    key={family.id}
                                    family={family}
                                    families={families}
                                />
                            ))}
                        </div>
                    </div>
                </div>

                <div className="absolute bottom-4 right-4 flex flex-col space-y-2">
                    <button
                        onClick={() => setScale((prev) => prev + 0.1)}
                        className="rounded bg-white p-2 shadow"
                    >
                        +
                    </button>
                    <button
                        onClick={() => setScale((prev) => prev - 0.1)}
                        className="rounded bg-white p-2 shadow"
                    >
                        −
                    </button>
                </div>
            </div>
        </App>
    );
}
