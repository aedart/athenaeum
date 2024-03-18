import{_ as c,M as o,p,q as r,R as s,t as n,N as a,U as e,a1 as u}from"./framework-efe98465.js";const d={},h=s("h1",{id:"cached-permissions",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#cached-permissions","aria-hidden":"true"},"#"),n(" Cached Permissions")],-1),m=s("code",null,"Registrar",-1),v=s("code",null,"AuthServiceProvider",-1),k={class:"table-of-contents"},g=u(`<h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>In your <code>config/acl.php</code> configuration file, you will find a <code>cache</code> setting. Here you can customise what cache store to use, how long permissions &amp; roles should be cached, and what key-prefix should be used.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ...</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Cache
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;cache&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token comment">// Name of the cache store (driver profile) to use.</span>
        <span class="token string single-quoted-string">&#39;store&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">,</span>

        <span class="token comment">// Time-to-live for cached permissions. (seconds)</span>
        <span class="token string single-quoted-string">&#39;ttl&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">60</span> <span class="token operator">*</span> <span class="token number">60</span><span class="token punctuation">,</span>

        <span class="token comment">// Cache key name to use for permissions</span>
        <span class="token string single-quoted-string">&#39;key&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;acl.permissions&#39;</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="when-changing-permissions-and-roles" tabindex="-1"><a class="header-anchor" href="#when-changing-permissions-and-roles" aria-hidden="true">#</a> When changing permissions and roles</h2><p>When you change your permissions or roles in the database, you will be required to flush the cached counterparts manually. The ACL <code>Registrar</code> offers a convenient way of doing so, via the <code>flush()</code> method.</p><p>In the following example, it is assumed that a web-interface exists for managing users&#39; roles. Once a role has been updated, the cached permissions &amp; roles can be cleared by invoking the mentioned <code>flush()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Controllers<span class="token punctuation">\\</span>Controller</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Roles</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Request</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Acl<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>RegistrarTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">RolesController</span> <span class="token keyword">extends</span> <span class="token class-name">Controller</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">RegistrarTrait</span><span class="token punctuation">;</span>
    
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">update</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Request</span> <span class="token variable">$request</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">Role</span> <span class="token variable">$role</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// ... update logic not shown ...</span>
        
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getRegistrar</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">flush</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>    
    <span class="token punctuation">}</span>
    
    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="no-auto-flush-offered" tabindex="-1"><a class="header-anchor" href="#no-auto-flush-offered" aria-hidden="true">#</a> No auto-flush offered</h3>`,8),f={href:"https://laravel.com/docs/10.x/eloquent#events",target:"_blank",rel:"noopener noreferrer"},b={href:"https://laravel.com/docs/10.x/eloquent#observers",target:"_blank",rel:"noopener noreferrer"};function _(y,w){const l=o("RouterLink"),t=o("router-link"),i=o("ExternalLinkIcon");return p(),r("div",null,[h,s("p",null,[n("By default, all permissions and their associated roles are cached by the ACL "),m,n(", which you can use in your "),v,n(", to define the permissions and how to resolve them ("),s("em",null,[n("See "),a(l,{to:"/archive/v7x/acl/setup.html"},{default:e(()=>[n("setup")]),_:1}),n(" for additional information")]),n("). In this section, you will find a brief introduction for how to manage the cache permissions.")]),s("nav",k,[s("ul",null,[s("li",null,[a(t,{to:"#configuration"},{default:e(()=>[n("Configuration")]),_:1})]),s("li",null,[a(t,{to:"#when-changing-permissions-and-roles"},{default:e(()=>[n("When changing permissions and roles")]),_:1}),s("ul",null,[s("li",null,[a(t,{to:"#no-auto-flush-offered"},{default:e(()=>[n("No auto-flush offered")]),_:1})])])])])]),g,s("p",null,[n("The current ACL package does not offer any automatic way of flushing the cached permissions & roles. Should you require such logic, then you may accomplish this via Eloquent's "),s("a",f,[n("events"),a(i)]),n(" and "),s("a",b,[n("event observers"),a(i)]),n(".")])])}const q=c(d,[["render",_],["__file","cache.html.vue"]]);export{q as default};
