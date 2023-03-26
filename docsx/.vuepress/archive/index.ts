import {PagesCollection} from "@aedart/vuepress-utils/contracts";
import {Archive} from "@aedart/vuepress-utils/navigation";
import Version1x from "./Version1x";
import Version2x from "./Version2x";
import Version3x from "./Version3x";
import Version7x from "./Version7x";
import Version8x from "./Version8x";

/**
 * The "current" version
 *
 * @type {PagesCollection}
 */
const CURRENT: PagesCollection = Version7x;

/**
 * The "next" version
 *
 * @type {PagesCollection}
 */
const NEXT: PagesCollection = Version8x;

/**
 * List of versions
 *
 * @type {PagesCollection[]}
 */
const VERSIONS: PagesCollection[] = [
    NEXT,
    CURRENT,
    Version3x,
    Version2x,
    Version1x
];

export default Archive.make(CURRENT, NEXT, VERSIONS);