import{_ as c,M as l,p as r,q as u,R as n,t as s,N as a,U as e,a1 as i}from"./framework-efe98465.js";const d={},h=n("h1",{id:"users",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#users","aria-hidden":"true"},"#"),s(" Users")],-1),k=n("code",null,"User",-1),g=n("code",null,"HasRoles",-1),m={class:"table-of-contents"},v=n("h2",{id:"assign-roles",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#assign-roles","aria-hidden":"true"},"#"),s(" Assign Roles")],-1),b=n("code",null,"assignRoles()",-1),f=n("code",null,"grantPermissions()",-1),_=i(`<ul><li>slugs</li><li>ids</li><li><code>Role</code> model instance</li><li><code>Collection</code> of role model instances</li><li>array of slugs, ids or role model instances.</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$role</span> <span class="token operator">=</span> <span class="token class-name static-context">Role</span><span class="token operator">::</span><span class="token function">findBySlug</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flight-manager&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Assign single role</span>
<span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">assignRoles</span><span class="token punctuation">(</span><span class="token variable">$role</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ... Or via array...</span>

<span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">assignRoles</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;reviewer&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;flight-manager&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ... Or single role via slug</span>

<span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">assignRoles</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flight-manager&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="un-assign-roles" tabindex="-1"><a class="header-anchor" href="#un-assign-roles" aria-hidden="true">#</a> Un-assign Roles</h2><p>When you need to un-assign roles, then use the <code>unassignRoles()</code>. It accepts the same type of arguments as the <code>assignRoles()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">unassignRoles</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;flight-manager&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="un-assign-all-roles" tabindex="-1"><a class="header-anchor" href="#un-assign-all-roles" aria-hidden="true">#</a> Un-assign all roles</h3><p>The <code>unassignAllRoles()</code> method can be used when you need to un-assign all roles for a user.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">unassignAllRoles</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="synchronise-roles" tabindex="-1"><a class="header-anchor" href="#synchronise-roles" aria-hidden="true">#</a> Synchronise roles</h2><p>If you require synchronising granted permissions, then use the <code>syncPermissions()</code> method.</p><p>To synchronise assigned roles, use the <code>syncRoles()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Regardless of what roles previously were assigned,</span>
<span class="token comment">// the user will now only be assign to the given roles...</span>
<span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">syncRoles</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;reviewer&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;flight-manager&#39;</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,12),y={href:"https://laravel.com/docs/9.x/eloquent-relationships#syncing-associations",target:"_blank",rel:"noopener noreferrer"},x=i(`<h2 id="check-user-s-roles" tabindex="-1"><a class="header-anchor" href="#check-user-s-roles" aria-hidden="true">#</a> Check user&#39;s roles</h2><p>Determining what roles are assigned to a given user, can be achieved via the following methods:</p><h3 id="has-role" tabindex="-1"><a class="header-anchor" href="#has-role" aria-hidden="true">#</a> Has role</h3><p>The <code>hasRoles()</code> method returns <code>true</code>, if given role is assigned to the user.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">echo</span> <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">hasRoles</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// e.g. false (0)</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="has-all-roles" tabindex="-1"><a class="header-anchor" href="#has-all-roles" aria-hidden="true">#</a> Has all roles</h3><p>To determine if a user has multiple roles assigned, use the <code>hasAllRoles()</code>. The method only returns <code>true</code>, if all given roles are assigned.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">echo</span> <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">hasAllRoles</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;reviewer&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// e.g. false (0)</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="has-any-roles" tabindex="-1"><a class="header-anchor" href="#has-any-roles" aria-hidden="true">#</a> Has any roles</h3><p>To determine if a user is assigned either (<em>one of</em>) of given roles, use the <code>hasAnyRoles()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Returns true if either role is assigned</span>
<span class="token keyword">echo</span> <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">hasAnyRoles</span><span class="token punctuation">(</span><span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;editor&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;reviewer&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// e.g. true (1)</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="check-user-s-permissions" tabindex="-1"><a class="header-anchor" href="#check-user-s-permissions" aria-hidden="true">#</a> Check user&#39;s permissions</h2>`,12),w=n("code",null,"AuthServiceProvider",-1),R={href:"https://laravel.com/docs/9.x/authorization#authorizing-actions-using-policies",target:"_blank",rel:"noopener noreferrer"},q=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers<span class="token punctuation">\\</span>Controller</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Flight</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Request</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">FlightController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">update</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Request</span> <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">Flight</span> <span class="token variable">$flight</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span><span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">user</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">can</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights.update&#39;</span><span class="token punctuation">,</span> <span class="token variable">$flight</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token function">abort</span><span class="token punctuation">(</span><span class="token number">403</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

        <span class="token comment">// The current user can update the flight post...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="cached-permissions" tabindex="-1"><a class="header-anchor" href="#cached-permissions" aria-hidden="true">#</a> Cached permissions</h3><p>It is important to understand that when using the ACL <code>Registrar</code> in your <code>AuthServiceProvider</code>, all permissions will be cached. Unless you are aware of this, you can experience unexpected behavior, should you change a user&#39;s roles, permissions...etc.</p>`,3),$=i(`<h3 id="manual-database-check" tabindex="-1"><a class="header-anchor" href="#manual-database-check" aria-hidden="true">#</a> Manual database check</h3><p>Should you require checking if a user is granted a specific permission, without using the cache, then you may use the <code>hasPermission()</code> method. It ONLY accepts a <code>Permission</code> model instance as argument and will perform a database query, to determine whether the user is granted the given permission or not.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$permission</span> <span class="token operator">=</span> <span class="token class-name static-context">Permission</span><span class="token operator">::</span><span class="token function">findBySlug</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;flights.destroy&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">hasPermission</span><span class="token punctuation">(</span><span class="token variable">$permission</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// E.g. true (1)</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3);function C(A,S){const o=l("RouterLink"),t=l("router-link"),p=l("ExternalLinkIcon");return r(),u("div",null,[h,n("p",null,[s("Your Eloquent "),k,s(" model should make use of the "),g,s(" trait. It enables assigning and un-assigning of roles. ("),n("em",null,[s("See "),a(o,{to:"/archive/v6x/acl/setup.html#the-hasroles-trait"},{default:e(()=>[s("setup")]),_:1})]),s(").")]),n("nav",m,[n("ul",null,[n("li",null,[a(t,{to:"#assign-roles"},{default:e(()=>[s("Assign Roles")]),_:1})]),n("li",null,[a(t,{to:"#un-assign-roles"},{default:e(()=>[s("Un-assign Roles")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#un-assign-all-roles"},{default:e(()=>[s("Un-assign all roles")]),_:1})])])]),n("li",null,[a(t,{to:"#synchronise-roles"},{default:e(()=>[s("Synchronise roles")]),_:1})]),n("li",null,[a(t,{to:"#check-user-s-roles"},{default:e(()=>[s("Check user's roles")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#has-role"},{default:e(()=>[s("Has role")]),_:1})]),n("li",null,[a(t,{to:"#has-all-roles"},{default:e(()=>[s("Has all roles")]),_:1})]),n("li",null,[a(t,{to:"#has-any-roles"},{default:e(()=>[s("Has any roles")]),_:1})])])]),n("li",null,[a(t,{to:"#check-user-s-permissions"},{default:e(()=>[s("Check user's permissions")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#cached-permissions"},{default:e(()=>[s("Cached permissions")]),_:1})]),n("li",null,[a(t,{to:"#manual-database-check"},{default:e(()=>[s("Manual database check")]),_:1})])])])])]),v,n("p",null,[s("Use the "),b,s(" method to assign one or more roles to a user. The method behaves similarly as the "),a(o,{to:"/archive/v6x/acl/roles.html#grant-permissions"},{default:e(()=>[f,s(" method")]),_:1}),s(", in that it too accepts a variety of argument types:")]),_,n("p",null,[s("For additional information about relations synchronisation, please review Laravel's "),n("a",y,[s("documentation"),a(p)]),s(".")]),x,n("p",null,[s("During runtime, if you have defined permissions in the "),w,s(" (See "),a(o,{to:"/archive/v6x/acl/setup.html"},{default:e(()=>[s("setup")]),_:1}),s("), you can use "),n("a",R,[s("Laravel's builtin mechanisms"),a(p)]),s(" to check a user's permissions.")]),q,n("p",null,[s("See "),a(o,{to:"/archive/v6x/acl/cache.html"},{default:e(()=>[s("Cached Permissions section")]),_:1}),s(" for additional information.")]),$])}const P=c(d,[["render",C],["__file","users.html.vue"]]);export{P as default};
