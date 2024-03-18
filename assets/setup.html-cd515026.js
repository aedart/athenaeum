import{_ as e,M as i,p as t,q as o,R as l,t as n,N as c,U as p,a1 as s}from"./framework-efe98465.js";const r={},d=s(`<h1 id="setup" tabindex="-1"><a class="header-anchor" href="#setup" aria-hidden="true">#</a> Setup</h1><h2 id="service-provider" tabindex="-1"><a class="header-anchor" href="#service-provider" aria-hidden="true">#</a> Service Provider</h2><p>Register <code>ETagsServiceProvider</code> inside your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>ETagsServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h2><p>Run <code>vendor:publish</code> to publish this package&#39;s assets.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>Once completed, you should have the following configuration file in your <code>/configs</code> directory:</p><ul><li><code>etags.php</code></li></ul><h3 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h3>`,10),u=s(`<div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>In the <code>config/etags.php</code> you can create or change the &quot;profiles&quot; for the Etags Generator.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Default ETag Generator
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;default_generator&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;DEFAULT_ETAG_GENERATOR&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Generator Profiles
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Generators<span class="token punctuation">\\</span>GenericGenerator</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token comment">// Hashing algorithm to be used for ETags flagged</span>
                <span class="token comment">// as &quot;weak&quot; (weak comparison)</span>
                <span class="token string single-quoted-string">&#39;weak_algo&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;crc32&#39;</span><span class="token punctuation">,</span>

                <span class="token comment">// Hashing algorithm to be used for ETags</span>
                <span class="token comment">// NOT flagged as &quot;weak&quot; (strong comparison)</span>
                <span class="token string single-quoted-string">&#39;strong_algo&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;sha1&#39;</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4);function v(m,g){const a=i("RouterLink");return t(),o("div",null,[d,l("p",null,[n("If you are using the "),c(a,{to:"/archive/v7x/core/"},{default:p(()=>[n("Athenaeum Core Application")]),_:1}),n(", then run the following command to publish assets:")]),u])}const k=e(r,[["render",v],["__file","setup.html.vue"]]);export{k as default};
