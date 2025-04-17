import Details from '@/Components/Details';
import { birth, burial, death, names } from '@/functions';
import App from '@/Layouts/App';
import { Person as P, PageProps } from '@/types';

export default function Person({ person }: PageProps<{ person: P }>) {
    return (
        <App title="person">
            <Details
                data={{
                    id: person.id,
                    sex: person.sex,
                    names: names(person.names),
                    birthday: birth(person.birth),
                    burial: burial(person.burial),
                    death: death(person.death),
                }}
            />
        </App>
    );
}
