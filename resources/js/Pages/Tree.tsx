import { person as personLink } from '@/functions';
import App from '@/Layouts/App';
import { Family, PageProps, Person } from '@/types';
import { useEffect, useRef, useState } from 'react';

function PersonCard({ person }: { person: Person | null | undefined }) {
    if (!person) return null;

    return (
        <div className="w-40 rounded-2xl bg-gray-50 p-4 text-center shadow-md">
            <div className="text-lg font-semibold">{personLink(person)}</div>
            <div className="text-sm text-gray-500">{person.sex}</div>
            <div className="text-xs text-gray-400">
                {person.birth?.date?.date ? `${person.birth.date.date}` : ''}
                {person.death?.date?.date ? ` - ${person.death.date.date}` : ''}
            </div>
        </div>
    );
}

function FamilyComponent({ family }: { family: Family }) {
    return (
        <div className="relative flex flex-col items-center space-y-6">
            <div className="relative z-10 flex space-x-6">
                <PersonCard person={family.husband} />
                <PersonCard person={family.wife} />
            </div>
            {family.children.length > 0 && (
                <div className="relative z-10 mt-4 flex space-x-4">
                    {family.children.map((child) => (
                        <PersonCard key={child.id} person={child} />
                    ))}
                </div>
            )}
        </div>
    );
}

export default function Tree({
    families,
    people,
}: PageProps<{
    families: { [key: string]: Family };
    people: { [key: string]: Person };
}>) {
    const containerRef = useRef<HTMLDivElement>(null);
    const [isDragging, setIsDragging] = useState(false);
    const [origin, setOrigin] = useState<{ x: number; y: number }>({
        x: 0,
        y: 0,
    });
    const [translate, setTranslate] = useState<{ x: number; y: number }>({
        x: 0,
        y: 0,
    });

    useEffect(() => {
        const handleMouseMove = (e: MouseEvent) => {
            if (isDragging) {
                setTranslate((prev) => ({
                    x: prev.x + e.movementX,
                    y: prev.y + e.movementY,
                }));
            }
        };

        const handleMouseUp = () => setIsDragging(false);

        document.addEventListener('mousemove', handleMouseMove);
        document.addEventListener('mouseup', handleMouseUp);

        return () => {
            document.removeEventListener('mousemove', handleMouseMove);
            document.removeEventListener('mouseup', handleMouseUp);
        };
    }, [isDragging]);

    return (
        <App title="tree" full>
            <div
                ref={containerRef}
                className="h-screen w-full cursor-grab select-none overflow-hidden active:cursor-grabbing"
                onMouseDown={(e) => {
                    setIsDragging(true);
                    setOrigin({ x: e.clientX, y: e.clientY });
                }}
            >
                <div
                    className="relative transition-transform duration-100"
                    style={{
                        transform: `translate(${translate.x}px, ${translate.y}px)`,
                    }}
                >
                    <div className="space-y-10 p-6">
                        {Object.values(families).map((family) => (
                            <FamilyComponent key={family.id} family={family} />
                        ))}
                    </div>
                </div>
            </div>
        </App>
    );
}
