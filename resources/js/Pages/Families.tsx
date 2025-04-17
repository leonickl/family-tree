import { person } from '@/functions';
import App from '@/Layouts/App';
import { Family, PageProps } from '@/types';
import { Link } from '@inertiajs/react';
import React from 'react';

export default function Families({
    families,
}: PageProps<{ families: Family[] }>) {
    const classes = 'border-b py-2 text-center';

    return (
        <App title="families">
            <div className="grid grid-cols-[auto_auto_auto]">
                {families.map((family, i) => {
                    const stripes = i % 2 ? 'bg-gray-100' : '';

                    return (
                        <React.Fragment key={family.id}>
                            <div className={`${classes} ${stripes}`}>
                                <Link href={route('family', family.id)}>
                                    {family.id}
                                </Link>
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {person(family.wife)}
                            </div>
                            <div className={`${classes} ${stripes}`}>
                                {person(family.husband)}
                            </div>
                        </React.Fragment>
                    );
                })}
            </div>
        </App>
    );
}
