import {PagesCollection} from "@aedart/vuepress-utils/contracts";
import {Archive} from "@aedart/vuepress-utils/navigation";
import Version1x from "./Version1x";
import Version2x from "./Version2x";
import Version3x from "./Version3x";
import Version4x from "./Version4x";
import Version5x from "./Version5x";
import Version6x from "./Version6x";
import Version7x from "./Version7x";
import Version8x from "./Version8x";
import Version9x from "./Version9x";

/**
 * The "current" version
 *
 * @type {PagesCollection}
 */
const CURRENT: PagesCollection = Version8x;

/**
 * The "next" version
 *
 * @type {PagesCollection}
 */
const NEXT: PagesCollection = Version9x;

/**
 * List of versions
 *
 * @type {PagesCollection[]}
 */
const VERSIONS: PagesCollection[] = [
    NEXT,
    CURRENT,
    Version7x,
    Version6x,
    Version5x,
    Version4x,
    Version3x,
    Version2x,
    Version1x
];

export default Archive.make(CURRENT, NEXT, VERSIONS);