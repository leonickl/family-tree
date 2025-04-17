import { Family, PageProps, Person } from '@/types';

type TreeNode = {
    person: Person | null;
    spouse: Person | null;
    children: TreeNode[];
};

function buildTree(
    rootFamilyId: string,
    families: Record<string, Family>,
): TreeNode {
    const family = families[rootFamilyId];
    if (!family) return { person: null, spouse: null, children: [] };

    const children = family.children
        .map((child) => {
            const childFamily = Object.values(families).find(
                (f) => f.husband?.id === child.id || f.wife?.id === child.id,
            );
            return buildTree(childFamily?.id ?? '', families);
        })
        .filter(Boolean);

    return {
        person: family.husband ?? null,
        spouse: family.wife ?? null,
        children,
    };
}

const NODE_WIDTH = 140;
const NODE_HEIGHT = 60;
const SPACING_X = 40;
const SPACING_Y = 100;

function renderNode(
    node: TreeNode,
    x: number,
    y: number,
    depth: number = 0,
): { elements: JSX.Element[]; width: number } {
    const elements: JSX.Element[] = [];

    // Render person + spouse side-by-side
    const personName = node.person?.names[0]?.given ?? 'Unknown';
    const spouseName = node.spouse?.names[0]?.given ?? 'Unknown';

    const coupleX = x;
    const coupleWidth = NODE_WIDTH * 2 + SPACING_X;

    elements.push(
        <g
            key={`${personName}-${spouseName}`}
            transform={`translate(${coupleX}, ${y})`}
        >
            <rect
                width={NODE_WIDTH}
                height={NODE_HEIGHT}
                fill="#cce4ff"
                rx={10}
            />
            <text x={10} y={30}>
                {personName}
            </text>

            <rect
                x={NODE_WIDTH + SPACING_X}
                width={NODE_WIDTH}
                height={NODE_HEIGHT}
                fill="#ffcce0"
                rx={10}
            />
            <text x={NODE_WIDTH + SPACING_X + 10} y={30}>
                {spouseName}
            </text>

            {/* Marriage line */}
            <line
                x1={NODE_WIDTH}
                y1={NODE_HEIGHT / 2}
                x2={NODE_WIDTH + SPACING_X}
                y2={NODE_HEIGHT / 2}
                stroke="#999"
            />
        </g>,
    );

    // Render children recursively
    let childX = x;
    let totalWidth = 0;

    node.children.forEach((childNode, idx) => {
        const result = renderNode(
            childNode,
            childX,
            y + NODE_HEIGHT + SPACING_Y,
            depth + 1,
        );
        elements.push(...result.elements);

        // Connect parent to child
        elements.push(
            <line
                key={`line-${depth}-${idx}`}
                x1={coupleX + coupleWidth / 2}
                y1={y + NODE_HEIGHT}
                x2={childX + result.width / 2}
                y2={y + NODE_HEIGHT + SPACING_Y}
                stroke="#999"
            />,
        );

        childX += result.width + SPACING_X;
        totalWidth += result.width + SPACING_X;
    });

    totalWidth = Math.max(totalWidth, coupleWidth);
    return { elements, width: totalWidth };
}

export default function Tree({
    families,
    people,
}: PageProps<{
    families: { [key: string]: Family };
    people: { [key: string]: Person };
}>) {
    const rootFamilyId = Object.keys(families)[0]; // pick your starting point
    const treeData = buildTree(rootFamilyId, families);

    const { elements } = renderNode(treeData, 50, 50);

    return (
        <svg width="4000" height="2000">
            {elements}
        </svg>
    );
}
