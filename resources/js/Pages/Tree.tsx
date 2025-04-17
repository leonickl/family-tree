import App from '@/Layouts/App';
import { Family, PageProps, Person } from '@/types';

function PersonCard({ person }: { person: Person | null | undefined }) {
    if (!person) return null;

    const fullName =
        person.names[0]?.name ||
        `${person.names[0]?.given || ''} ${person.names[0]?.surname || ''}`;

    return (
        <div className="w-40 rounded-2xl bg-white p-4 text-center shadow-md">
            <div className="text-lg font-semibold">{fullName}</div>
            <div className="text-sm text-gray-500">{person.sex}</div>
            <div className="text-xs text-gray-400">
                {person.birth?.date?.date ? `b. ${person.birth.date.date}` : ''}
                {person.death?.date?.date
                    ? ` - d. ${person.death.date.date}`
                    : ''}
            </div>
        </div>
    );
}

function FamilyComponent({ family }: { family: Family }) {
    return (
        <div className="flex flex-col items-center space-y-6">
            <div className="flex space-x-6">
                <PersonCard person={family.husband} />
                <PersonCard person={family.wife} />
            </div>
            {family.children.length > 0 && (
                <div className="mt-4 flex space-x-4">
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
    return (
        <App title="tree">
            <div className="space-y-10 p-6">
                {Object.values(families).map((family) => (
                    <FamilyComponent key={family.id} family={family} />
                ))}
            </div>
        </App>
    );
}
