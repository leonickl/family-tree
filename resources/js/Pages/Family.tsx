import Details from '@/Components/Details';
import { event, person } from '@/functions';
import App from '@/Layouts/App';
import { Family as F, PageProps } from '@/types';

export default function Family({ family }: PageProps<{ family: F }>) {
    return (
        <App title="family">
            <Details
                data={{
                    id: family.id,
                    husband: person(family.husband),
                    wife: person(family.wife),
                    children: (
                        <div className="flex flex-row flex-wrap gap-5">
                            {family.children.map((child) => (
                                <div key={child.id}>{person(child)}</div>
                            ))}
                        </div>
                    ),
                    events: family.events.map((ev) => event(ev)),
                }}
            />
        </App>
    );
}
