import{_ as c,M as o,p as i,q as l,R as s,t as n,N as a,U as e,a1 as r}from"./framework-efe98465.js";const u={},d=s("h1",{id:"tip-create-a-base-builder",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#tip-create-a-base-builder","aria-hidden":"true"},"#"),n(" Tip: Create a base builder")],-1),k={class:"table-of-contents"},v=r(`<h2 id="example-abstract-builder" tabindex="-1"><a class="header-anchor" href="#example-abstract-builder" aria-hidden="true">#</a> Example: abstract builder</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>BaseBuilder</span> <span class="token keyword">as</span> Builder<span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>MatchingProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>SearchProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>ConstraintsProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Processors<span class="token punctuation">\\</span>SortingProcessor</span><span class="token punctuation">;</span>

<span class="token keyword">abstract</span> <span class="token keyword">class</span> <span class="token class-name-definition class-name">BaseFiltersBuilder</span> <span class="token keyword">extends</span> <span class="token class-name">Builder</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">processors</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;match&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">MatchingProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

            <span class="token string single-quoted-string">&#39;search&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">SearchProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">columns</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">searchColumns</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

            <span class="token string single-quoted-string">&#39;filter&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">ConstraintsProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">filters</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">filters</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">propertiesToColumns</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">propertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

            <span class="token string single-quoted-string">&#39;sort&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">SortingProcessor</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">sortable</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">sortable</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">propertiesToColumns</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">sortingPropertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">defaultSort</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">defaultSorting</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
                <span class="token operator">-&gt;</span><span class="token function">force</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token doc-comment comment">/**
     * Get list of table columns that the search filter
     * must match search terms against
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">string</span><span class="token punctuation">[</span><span class="token punctuation">]</span></span>
     */</span>
    <span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">searchColumns</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>

    <span class="token doc-comment comment">/**
     * Get list of allowed filterable properties and
     * their corresponding filter to be used.
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">array</span></span>
     */</span>
    <span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">filters</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>

    <span class="token doc-comment comment">/**
     * Get map of properties and their corresponding table
     * column name.
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">array</span></span>
     */</span>
    <span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">propertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span><span class="token punctuation">;</span>

    <span class="token doc-comment comment">/**
     * Map of properties and their corresponding table column name,
     * to be used for sorting.
     *
     * <span class="token keyword">@see</span> propertiesColumnsMap
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">array</span></span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">sortingPropertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">propertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token doc-comment comment">/**
     * Get list of sortable properties
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">string</span><span class="token punctuation">[</span><span class="token punctuation">]</span></span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">sortable</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token function">array_keys</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">filters</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token doc-comment comment">/**
     * Get the default sorting value to be used, when
     * none is requested.
     *
     * <span class="token keyword">@return</span> <span class="token class-name"><span class="token keyword">string</span></span>
     */</span>
    <span class="token keyword">abstract</span> <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">defaultSorting</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span> 
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="example-concrete-builder" tabindex="-1"><a class="header-anchor" href="#example-concrete-builder" aria-hidden="true">#</a> Example: concrete builder</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">class</span> <span class="token class-name-definition class-name">UsersFiltersBuilder</span> <span class="token keyword">extends</span> <span class="token class-name">BaseFiltersBuilder</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">searchColumns</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;id&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;email&#39;</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">filters</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;id&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">NumericFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">StringFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;email&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">StringFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;administrator&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">BooleanFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;email_verified_at&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">DatetimeFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;created_at&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">DatetimeFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;updated_at&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">DatetimeFilter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">propertiesColumnsMap</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;administrator&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;is_admin&#39;</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">defaultSorting</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token string single-quoted-string">&#39;id desc&#39;</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4);function m(b,g){const t=o("RouterLink"),p=o("router-link");return i(),l("div",null,[d,s("p",null,[n('You might find it useful to create a "base" '),a(t,{to:"/archive/v5x/filters/builder.html"},{default:e(()=>[n("builder")]),_:1}),n(", for you application. Doing so will allow you to specify common "),a(t,{to:"/archive/v5x/filters/processor.html"},{default:e(()=>[n("processors")]),_:1}),n(" and configuration. The following shows a possible abstract builder, using the predefined processors that are available in this package.")]),s("nav",k,[s("ul",null,[s("li",null,[a(p,{to:"#example-abstract-builder"},{default:e(()=>[n("Example: abstract builder")]),_:1})]),s("li",null,[a(p,{to:"#example-concrete-builder"},{default:e(()=>[n("Example: concrete builder")]),_:1})])])]),v])}const y=c(u,[["render",m],["__file","tip.html.vue"]]);export{y as default};
