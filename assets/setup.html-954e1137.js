import{_ as t,M as l,p as o,q as d,R as n,N as e,U as i,t as s,a1 as c}from"./framework-efe98465.js";const r={},p=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),u={class:"table-of-contents"},v=c(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>AuditTrailServiceProvider</code> in your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Audit<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>AuditTrailServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h2><p>Run <code>vendor:publish</code> to publish package&#39;s assets.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>The package should publish a <code>config/audit-trail.php</code> and a migration file inside your <code>database/migrations</code> directory.</p><p><strong>Please make sure to configure the audit trail components, before running migrations!</strong></p><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>In your <code>audit-trail.php</code> configuration, you will find various settings that your can change as needed. Amongst them is a map of the Eloquent models for your application user and the &quot;audit trail&quot; model.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Audit Trail Model
    |--------------------------------------------------------------------------
    |
    | The Eloquent model to be used for audit trail
    */</span>

    <span class="token string single-quoted-string">&#39;models&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token comment">// Your application&#39;s user model</span>
        <span class="token string single-quoted-string">&#39;user&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token comment">// The Audit Trail model</span>
        <span class="token string single-quoted-string">&#39;audit_trail&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Audit<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>AuditTrail</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Database table
    |--------------------------------------------------------------------------
    |
    | Name of the database table that contains audit trail
    */</span>

    <span class="token string single-quoted-string">&#39;table&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;audit_trails&#39;</span><span class="token punctuation">,</span>

   <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,11);function m(b,h){const a=l("router-link");return o(),d("div",null,[p,n("nav",u,[n("ul",null,[n("li",null,[e(a,{to:"#register-service-provider"},{default:i(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[e(a,{to:"#publish-assets"},{default:i(()=>[s("Publish Assets")]),_:1})]),n("li",null,[e(a,{to:"#configuration"},{default:i(()=>[s("Configuration")]),_:1})])])]),v])}const g=t(r,[["render",m],["__file","setup.html.vue"]]);export{g as default};
