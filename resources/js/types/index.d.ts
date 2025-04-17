export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
};

export type Family = {
    id: string;
    husband: Person | null | undefined;
    wife: Person | null | undefined;
    children: Person[];
    events: Event[];
};

export type Person = {
    id: string;
    birth: Birth | null | undefined;
    burial: Burial | null | undefined;
    death: Death | null | undefined;
    names: Names;
    sex: string;
    events: Event[];
};

export type Date = {
    date: string;
};

export type Event = {
    type: string;
    date: Date;
    place: any;
};

export type Birth = {
    date: Date | null | undefined;
};

export type Burial = {
    date: Date | null | undefined;
};

export type Death = {
    date: Date | null | undefined;
};

export type Names = Name[];

export type Name = {
    name: string | null | undefined;
    given: string | null | undefined;
    surname: string | null | undefined;
};
