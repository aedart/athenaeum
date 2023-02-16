const version1 = require('./version1x');
const version2 = require('./version2x');
const version3 = require('./version3x');
const version4 = require('./version4x');
const version5 = require('./version5x');
const version6 = require('./version6x');
const version7 = require('./version7x');
const version8 = require('./version8x');

module.exports = {

    /**
     * The current version
     */
    current : 'v7.x',

    /**
     * The next major version
     */
    next: 'v8.x',

    /**
     * List of available navigations
     *
     * @var {Object[]}
     */
    versions : [
        { name: 'v8.x', link: '/archive/v8x/', sidebar: version8.sidebar()  },
        { name: 'v7.x', link: '/archive/v7x/', sidebar: version7.sidebar()  },
        { name: 'v6.x', link: '/archive/v6x/', sidebar: version6.sidebar()  },
        { name: 'v5.x', link: '/archive/v5x/', sidebar: version5.sidebar()  },
        { name: 'v4.x', link: '/archive/v4x/', sidebar: version4.sidebar()  },
        { name: 'v3.x', link: '/archive/v3x/', sidebar: version3.sidebar()  },
        { name: 'v2.x', link: '/archive/v2x/', sidebar: version2.sidebar()  },
        { name: 'v1.x', link: '/archive/v1x/', sidebar: version1.sidebar()  },
    ],

    /**
     * "Current major version" label
     */
    currentName: 'current',

    /**
     * "Next major version" label
     */
    nextName: 'next',

    /**
     * Link to "Current major version" version
     */
    currentLink: '/archive/current/',

    /**
     * Link to "Next major version" version
     */
    nextLink: '/archive/next/',

    /**
     * Returns the "archive" navigation items
     *
     * @return {Object[]}
     */
    archiveItems : function () {
        let output = [];

        this.versions.forEach((item) => {
            // If version is next
            if(item.name === this.next){
                item.name = this.nextName;
                item.link = this.nextLink;
            }

            // If version is current
            if(item.name === this.current){
                item.name = this.currentName;
                item.link = this.currentLink;
            }

            output.push(this.makeArchiveItem(item));
        });

        return output;
    },

    /**
     * Returns the "sidebar" navigation items
     *
     * @param {Object} [additional={}] Additional sidebar items
     *
     * @return {Object}
     */
    sidebarItems : function (additional) {
        let output = {};

        if(!additional){
            additional = {};
        }

        this.versions.forEach((item) => {
            // If version is next
            if(item.name === this.next){
                item.link = this.nextLink;
            }

            // If version is current
            if(item.name === this.current){
                item.link = this.currentLink;
            }

            let sidebarItem = this.makeSidebarItem(item);

            output = Object.assign(output, sidebarItem);
        });

        // Add evt. additional sidebar items
        return  Object.assign(output, additional);
    },

    /**
     * Creates a new archive navigation item
     *
     * @param {Object} item
     *
     * @return {{name: *, link: (string|*|((url: string) => string)|string)}}
     */
    makeArchiveItem : function(item){
        return {
            text: item.name,
            link: item.link
        };
    },

    /**
     * Creates a new sidebar item
     *
     * @param {Object} item
     *
     * @return {Object} E.g. { '/archive/current/' : {...} }
     */
    makeSidebarItem: function(item){
        return {
            [item.link] : item.sidebar
        }
    }
};
