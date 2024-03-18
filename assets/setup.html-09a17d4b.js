import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},p=e(`<h1 id="setup" tabindex="-1"><a class="header-anchor" href="#setup" aria-hidden="true">#</a> Setup</h1><h2 id="inside-laravel" tabindex="-1"><a class="header-anchor" href="#inside-laravel" aria-hidden="true">#</a> Inside Laravel</h2><p>If you are using this component inside a typical Laravel application, then all you have to do, is to register <code>ConfigLoaderServiceProvider</code>. This can be done in your <code>config/app.php</code> file.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoload Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>ConfigLoaderServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Once you have registered the service, you can obtain an instance of the configuration <code>Loader</code> via <code>ConfigLoaderTrait</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>ConfigLoaderTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyConfigLoadService</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ConfigLoaderTrait</span><span class="token punctuation">;</span>
    
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">load</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$loader</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getConfigLoader</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="outside-laravel" tabindex="-1"><a class="header-anchor" href="#outside-laravel" aria-hidden="true">#</a> Outside Laravel</h2><p>Should you decide to use this component outside a Laravel application, then you need to setup a few dependencies, before able to load configuration.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Loader</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Parsers<span class="token punctuation">\\</span>Factories<span class="token punctuation">\\</span>FileParserFactory</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>Repository</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Filesystem<span class="token punctuation">\\</span>Filesystem</span><span class="token punctuation">;</span>

<span class="token variable">$loader</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Loader</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$loader</span><span class="token operator">-&gt;</span><span class="token function">setConfig</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Repository</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$loader</span><span class="token operator">-&gt;</span><span class="token function">setFile</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Filesystem</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$loader</span><span class="token operator">-&gt;</span><span class="token function">setParserFactory</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">FileParserFactory</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,9),o=[p];function i(c,l){return s(),a("div",null,o)}const d=n(t,[["render",i],["__file","setup.html.vue"]]);export{d as default};
