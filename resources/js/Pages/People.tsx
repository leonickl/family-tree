import { birth, death, person as personLink } from '@/functions';
import App from '@/Layouts/App';
import { PageProps, Person } from '@/types';
import { Link } from '@inertiajs/react';
import React from 'react';

export default function People({ people }: PageProps<{ people: Person[] }>) {
    const classes = 'border-b py-2 text-center';

    return (
        <App title="people">
            <div className="grid grid-cols-[auto_auto_auto_auto_auto]">
                {people.map((person, i) => {
                    const stripes = i % 2 ? 'bg-gray-100' : '';

                    return (
                        <React.Fragment key={person.id}>
                            <div className={`${classes} ${stripes}`}>
                                <Link href={route('person', person.id)}>
                                    {person.id}
                                </Link>
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {personLink(person)}
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {person.sex}
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {birth(person.birth)}
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {death(person.death)}
                            </div>
                        </React.Fragment>
                    );
                })}
            </div>
        </App>
    );
}
