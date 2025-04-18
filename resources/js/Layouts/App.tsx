import { __ } from '@/functions';
import { Head } from '@inertiajs/react';
import { PropsWithChildren } from 'react';
import AuthenticatedLayout from './AuthenticatedLayout';

export default function App({
    title,
    children,
    full = false,
}: PropsWithChildren<{ title: string; full?: boolean }>) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                    {__(title)}
                </h2>
            }
        >
            <Head title={__(title)} />

            <div className="py-12">
                <div
                    className={`mx-auto ${full ? 'w-full' : 'max-w-7xl'} sm:px-6 lg:px-8`}
                >
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
