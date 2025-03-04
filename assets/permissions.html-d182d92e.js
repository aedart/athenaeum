import{_ as l,M as o,p as c,q as r,R as s,N as a,U as t,t as n,a1 as p}from"./framework-efe98465.js";const u={},d=s("h1",{id:"permissions",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#permissions","aria-hidden":"true"},"#"),n(" Permissions")],-1),m=s("p",null,[n("Before you are able to grant permissions to roles, they must first be created. But, as you might have noticed, each permission must belong to a permission group. This makes creating permissions slightly cumbersome. Therefore, to ease permissions creation, you can make use of the "),s("code",null,"createWithPermissions()"),n(" method, in the permissions group model.")],-1),k={class:"table-of-contents"},g=s("h2",{id:"create-new-migration",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#create-new-migration","aria-hidden":"true"},"#"),n(" Create new migration")],-1),h=s("em",null,"SHOULD",-1),v={href:"https://spatie.be/docs/laravel-permission/v4/best-practices/roles-vs-permissions",target:"_blank",rel:"noopener noreferrer"},b=p(`<div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan make:migration installs_flight_permissions
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="create-permissions-and-group" tabindex="-1"><a class="header-anchor" href="#create-permissions-and-group" aria-hidden="true">#</a> Create Permissions and Group</h2><p>Inside your migration class, use the <code>createWithPermissions()</code> method to create a new permissions group, with it&#39;s desired permissions. The method accepts a unique slug identifier, along with an array of permissions. The array has to be formatted accordingly:</p><ul><li>key: unique permission slug (<em>prefixed with group&#39;s slug</em>)</li><li>value: array containing permission&#39;s name and description (<em>optional</em>)</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Permissions<span class="token punctuation">\\</span>Group</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Migrations<span class="token punctuation">\\</span>Migration</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">InstallsFlightPermissions</span> <span class="token keyword">extends</span> <span class="token class-name">Migration</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">up</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$name</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Flight permissions&#39;</span><span class="token punctuation">;</span> 
        <span class="token variable">$description</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Permissions related to flight records&#39;</span><span class="token punctuation">;</span>

        <span class="token class-name static-context">Group</span><span class="token operator">::</span><span class="token function">createWithPermissions</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;index&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;List flights&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;description&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Ability to view list of flights&#39;</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;show&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Show flight&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;description&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Ability to view a single flight&#39;</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
            
            <span class="token comment">// ... remaining not shown ...</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$description</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">down</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token class-name static-context">Group</span><span class="token operator">::</span><span class="token function">findBySlugOrFail</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights&#39;</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">forceDelete</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="permission-slug-prefixes" tabindex="-1"><a class="header-anchor" href="#permission-slug-prefixes" aria-hidden="true">#</a> Permission slug prefixes</h2><p>In the above example, a new permission group is created, using <code>flights</code> as it&#39;s slug identifier. Each permission&#39;s slug is prefixed with the group&#39;s slug, separated by a dot (<code>.</code>). Thus, from the above example, the following permission slugs are inserted into the database:</p><ul><li><code>flights.index</code></li><li><code>flights.show</code></li></ul><p>Later in you application, you will be able to check against these permissions:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers<span class="token punctuation">\\</span>Controller</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">FlightController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">index</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Request</span> <span class="token variable">$request</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">user</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">cannot</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights.index&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token function">abort</span><span class="token punctuation">(</span><span class="token number">403</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

        <span class="token comment">// ...remaining not shown</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="disable-prefixes" tabindex="-1"><a class="header-anchor" href="#disable-prefixes" aria-hidden="true">#</a> Disable prefixes</h3><p>If you do not wish your permission&#39;s slugs to be prefixed, then you can disable this behaviour by setting the <code>$prefix</code> argument to <code>false</code>, when using the <code>createWithPermissions()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$name</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Flight permissions&#39;</span><span class="token punctuation">;</span> 
<span class="token variable">$description</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Permissions related to flight records&#39;</span><span class="token punctuation">;</span>
<span class="token variable">$prefix</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Group</span><span class="token operator">::</span><span class="token function">createWithPermissions</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;show-flights-list&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;List flights&#39;</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;description&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Ability to view list of flights&#39;</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    
    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token variable">$name</span><span class="token punctuation">,</span> <span class="token variable">$description</span><span class="token punctuation">,</span> <span class="token variable">$prefix</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>From the above example, the following permission slug is inserted into the database:</p><ul><li><code>show-flights-list</code></li></ul>`,15),f={class:"custom-container tip"},y=s("p",{class:"custom-container-title"},"How should you name your permissions?",-1),w=s("p",null,"If you find yourself wondering how you should name your permission slugs, perhaps you can use the same names as for your routes.",-1),_={href:"https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller",target:"_blank",rel:"noopener noreferrer"},x=p('<h2 id="find-or-create-behaviour" tabindex="-1"><a class="header-anchor" href="#find-or-create-behaviour" aria-hidden="true">#</a> Find or create behaviour</h2><p>The <code>createWithPermissions()</code> method attempts to find a permissions group with the requested slug. Only if the group does not exist, then it will be created. This allows you to add more permissions to the same group, at a later point.</p><div class="custom-container warning"><p class="custom-container-title">Caution</p><p>The &quot;find or create&quot; behaviour does NOT apply to the permissions. Each given permission is attempted created. This means that if you provide a permission slug that already exists, then <code>createWithPermissions()</code> will fails with a <em>&quot;unique key constraint violation&quot;</em> database exception.</p><p>Should you wish to change a permission, then you will have to do so manually, e.g. by using the <code>Permission</code> Eloquent model.</p></div>',3);function q(P,$){const e=o("router-link"),i=o("ExternalLinkIcon");return c(),r("div",null,[d,m,s("nav",k,[s("ul",null,[s("li",null,[a(e,{to:"#create-new-migration"},{default:t(()=>[n("Create new migration")]),_:1})]),s("li",null,[a(e,{to:"#create-permissions-and-group"},{default:t(()=>[n("Create Permissions and Group")]),_:1})]),s("li",null,[a(e,{to:"#permission-slug-prefixes"},{default:t(()=>[n("Permission slug prefixes")]),_:1}),s("ul",null,[s("li",null,[a(e,{to:"#disable-prefixes"},{default:t(()=>[n("Disable prefixes")]),_:1})])])]),s("li",null,[a(e,{to:"#find-or-create-behaviour"},{default:t(()=>[n("Find or create behaviour")]),_:1})])])]),g,s("p",null,[n("Your application "),h,n(" be "),s("a",v,[n("coded against it's available permissions"),a(i)]),n(". It would therefore be beneficial to install them via database migrations.")]),b,s("div",f,[y,w,s("p",null,[n("See Laravel's "),s("a",_,[n("resource routes"),a(i)]),n(" documentation for inspiration.")])]),x])}const T=l(u,[["render",q],["__file","permissions.html.vue"]]);export{T as default};
