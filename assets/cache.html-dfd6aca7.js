import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},i=e(`<h1 id="cache" tabindex="-1"><a class="header-anchor" href="#cache" aria-hidden="true">#</a> Cache</h1><p><strong>Driver</strong>: <code>\\Aedart\\Translation\\Exports\\Drivers\\CacheExporter</code></p><p>A wrapper exporter that caches the resulting translations from another exporter. Configure the exporter profile in your <code>config/translations-exporter.php</code>:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ...previous not shown...</span>
    
    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Exporter Profiles
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;cache&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Translation<span class="token punctuation">\\</span>Exports<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>CacheExporter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token comment">// The exporter to use</span>
                <span class="token string single-quoted-string">&#39;exporter&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;lang_js_json&#39;</span><span class="token punctuation">,</span>

                <span class="token comment">// The cache store to use</span>
                <span class="token string single-quoted-string">&#39;cache&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;CACHE_DRIVER&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;file&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

                <span class="token comment">// Time-to-live (in seconds)</span>
                <span class="token string single-quoted-string">&#39;ttl&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">3600</span><span class="token punctuation">,</span>

                <span class="token comment">// Cache key prefix</span>
                <span class="token string single-quoted-string">&#39;prefix&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;trans_export_&#39;</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>

        <span class="token string single-quoted-string">&#39;lang_js_json&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Translation<span class="token punctuation">\\</span>Exports<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>LangJsJsonExporter</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;json_key&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;__JSON__&#39;</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;json_options&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">0</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;depth&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">512</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>

        <span class="token comment">// ... remaining profiles not shown...</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4),p=[i];function o(l,c){return s(),a("div",null,p)}const u=n(t,[["render",o],["__file","cache.html.vue"]]);export{u as default};
