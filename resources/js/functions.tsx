import { Link } from '@inertiajs/react';
import {
    Birth,
    Burial,
    Date,
    Death,
    Event,
    Family,
    Names,
    Person,
} from './types';

export function __(key: string) {
    return key;
}

export function names(names: Names | null | undefined) {
    return names
        ? names
              .map((name) => `${name.given ?? '---'} ${name.surname ?? '---'}`)
              .join()
        : '---';
}

export function person(person: Person | null | undefined) {
    return person ? (
        <Link href={route('person', person.id)} className='underline decoration-gray-500 hover:decoration-dashed'>{names(person.names)}</Link>
    ) : (
        '---'
    );
}

export function family(family: Family | null | undefined) {
    return family ? (
        <Link href={route('family', family.id)} className='underline decoration-gray-500 hover:decoration-dashed'>
            {names(family.wife?.names)} & {names(family.husband?.names)}
        </Link>
    ) : (
        '---'
    );
}

export function event(event: Event | null | undefined) {
    return event ? (
        <>
            {event.type} {__('at')} {event.date} {__('in')} {event.place}
        </>
    ) : (
        '---'
    );
}

export function date(date: Date | null | undefined) {
    return date ? <>{date.date}</> : '---';
}

export function birth(birth: Birth | null | undefined) {
    return birth ? <>{date(birth.date)}</> : '---';
}

export function burial(burial: Burial | null | undefined) {
    return burial ? <>{date(burial.date)}</> : '---';
}

export function death(death: Death | null | undefined) {
    return death ? <>{date(death.date)}</> : '---';
}
