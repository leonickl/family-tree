import { person as personLink } from '@/functions';
import App from '@/Layouts/App';
import { Family, PageProps, Person } from '@/types';
import React, { useEffect, useMemo, useRef, useState } from 'react';

function PersonCard({
    person,
    topLine = false,
}: {
    person: Person | null | undefined;
    topLine?: boolean;
}) {
    return person ? (
        <div className="relative h-20 w-52 rounded-2xl border border-slate-400 bg-gray-50 p-3 text-center shadow-md">
            {topLine && (
                <div className="absolute -top-[23px] left-1/2 h-[22px] w-[2px] bg-gray-300"></div>
            )}

            <div className="text-md font-semibold">{personLink(person)}</div>

            <div className="text-xs text-gray-400">
                {person.birth?.date?.date ? `${person.birth.date.date}` : ''}
                {person.death?.date?.date ? ` - ${person.death.date.date}` : ''}
            </div>
        </div>
    ) : null;
}

function FamilyNode({
    family,
    families,
    level = 0,
    visited = new Set<string>(),
    child = undefined,
}: {
    family: Family;
    families: { [key: string]: Family };
    level?: number;
    visited?: Set<string>;
    child?: Person;
}) {
    const branchVisited = new Set(visited);

    if (branchVisited.has(family.id)) {
        return null;
    }

    branchVisited.add(family.id);

    const childFamilies = useMemo(() => {
        return Object.values(families)
            .map((f): [Person | undefined, Family] => {
                const child = family.children.find(
                    (child) =>
                        child.id === f.husband?.id || child.id === f.wife?.id,
                );

                return [child, f];
            })
            .filter(([child]) => child);
    }, [families, family.children]);

    const standaloneChildren = useMemo(() => {
        return family.children.filter((child) => {
            return !Object.values(families).some(
                (f) => f.husband?.id === child.id || f.wife?.id === child.id,
            );
        });
    }, [families, family.children]);

    return (
        <div className="relative flex flex-col items-center">
            <div className="relative mb-5 flex items-center">
                <PersonCard
                    person={family.husband}
                    topLine={family.husband?.id === child?.id}
                />

                <div className="h-[2px] w-10 bg-gray-300"></div>

                <PersonCard
                    person={family.wife}
                    topLine={family.wife?.id === child?.id}
                />
            </div>

            {(standaloneChildren.length > 0 || childFamilies.length > 0) && (
                <div className="absolute top-10 h-[62px] w-[2px] bg-gray-300"></div>
            )}

            <div className="flex flex-col gap-5 items-center">
                <div className="w-[calc(100%-208px)] h-[2px] bg-gray-300" />

                <div className="flex flex-row items-start gap-5">
                    {standaloneChildren.length > 0 &&
                        standaloneChildren.map((child) => (
                            <PersonCard key={child.id} person={child} topLine />
                        ))}

                    {childFamilies.length > 0 &&
                        childFamilies.map(([child, childFamily]) => (
                            <div
                                key={childFamily.id}
                                className="flex flex-col items-center"
                            >
                                <FamilyNode
                                    child={child}
                                    family={childFamily}
                                    families={families}
                                    level={level + 1}
                                    visited={branchVisited}
                                />
                            </div>
                        ))}
                </div>
            </div>
        </div>
    );
}

export default function Tree({
    families,
}: PageProps<{
    families: { [key: string]: Family };
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
