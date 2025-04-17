import { __ } from '@/functions';
import React from 'react';

export default function Details({
    data,
}: {
    data: { [key: string]: React.ReactNode };
}) {
    return (
        <div className="grid grid-cols-2">
            {Object.entries(data).map(([key, value]) => (
                <React.Fragment key={key}>
                    <div className="border-b py-2 font-bold">{__(key)}</div>
                    <div className="flex flex-row items-center border-b">
                        {value}
                    </div>
                </React.Fragment>
            ))}
        </div>
    );
}
