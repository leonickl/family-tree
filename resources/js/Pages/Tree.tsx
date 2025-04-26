import { FamilyTree } from '@/Tree/FamilyTree';
import { Family, PageProps, Person } from '@/types';

import {
    buildFamilyAndRelations,
    RawFamilyMember,
    RawFamilyRelation,
} from '../Tree/utils';

import { birth, death, names } from '@/functions';
import 'reactflow/dist/style.css';

export default function Tree({
    families,
    people,
}: PageProps<{ families: Family[]; people: Person[] }>) {
    const familyMembers = people.map((person) => ({
        id: person.id,
        data: {
            title: names(person.names),
            titleBgColor: 'rgb(63, 108, 191)',
            titleTextColor: 'white',
            subtitles: [birth(person.birth), death(person.death)],
            sex: person.sex,
            badges: [],
        },
    })) as RawFamilyMember[];

    const familyRelations: RawFamilyRelation[] = [];

    families.forEach((family) => {
        if (family.husband && family.wife) {
            familyRelations.push({
                relationType: 'Partner',
                prettyType: 'Partner',
                toId: family.husband.id,
                fromId: family.wife.id,
                isInnerFamily: true,
            });

            familyRelations.push({
                relationType: 'Partner',
                prettyType: 'Partner',
                toId: family.wife.id,
                fromId: family.husband.id,
                isInnerFamily: true,
            });
        }

        family.children.forEach((child) => {
            if (family.husband) {
                familyRelations.push({
                    relationType: 'Child',
                    prettyType: 'Child',
                    toId: child.id,
                    fromId: family.husband.id,
                    isInnerFamily: true,
                });

                familyRelations.push({
                    relationType: 'Parent',
                    prettyType: 'Parent',
                    toId: family.husband.id,
                    fromId: child.id,
                    isInnerFamily: true,
                });
            }

            if (family.wife) {
                familyRelations.push({
                    relationType: 'Child',
                    prettyType: 'Child',
                    toId: child.id,
                    fromId: family.wife.id,
                    isInnerFamily: true,
                });

                familyRelations.push({
                    relationType: 'Parent',
                    prettyType: 'Parent',
                    toId: family.wife.id,
                    fromId: child.id,
                    isInnerFamily: true,
                });
            }
        });

        family.children.forEach((one) => {
            family.children.forEach((other) => {
                if (one.id !== other.id) {
                    familyRelations.push({
                        relationType: 'Sibling',
                        prettyType: 'Sibling',
                        toId: one.id,
                        fromId: other.id,
                        isInnerFamily: true,
                    });
                }
            });
        });
    });

    const [familyMembersRecord, familyRelationsRecord] =
        buildFamilyAndRelations(
            familyMembers as RawFamilyMember[],
            familyRelations as RawFamilyRelation[],
        );

    const rootMember = familyMembersRecord['I500079']; // TODO: change

    return (
        <div style={{ height: '100vh', width: '100vw' }}>
            <FamilyTree
                familyMembers={familyMembersRecord}
                familyRelations={familyRelationsRecord}
                rootMember={rootMember}
            />
        </div>
    );
}
