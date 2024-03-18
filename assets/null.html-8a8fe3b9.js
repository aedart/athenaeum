import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const t={},i=e(`<h1 id="null" tabindex="-1"><a class="header-anchor" href="#null" aria-hidden="true">#</a> Null</h1><p><strong>Driver</strong>: <code>\\Aedart\\Antivirus\\Scanners\\NullScanner</code></p><p>The Null scanner is intended for testing, or situation when a scanner is required, yet not intended to trigger an actual virus-scan. For instance, if your application runs CI tests of file uploads, then this driver might be helpful, if you wish to disable scanning of those files.</p><h2 id="options" tabindex="-1"><a class="header-anchor" href="#options" aria-hidden="true">#</a> Options</h2><p>The following shows the available options for the Null scanner.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ...previous not shown...</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;null&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>NullScanner</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token comment">// Whether scanner should &quot;pass&quot; file scans (true), or</span>
                <span class="token comment">// &quot;fail&quot; them (false).</span>
                <span class="token string single-quoted-string">&#39;should_pass&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>
        
        <span class="token comment">// ...other profiles not shown...</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6),l=[i];function o(c,p){return s(),a("div",null,l)}const u=n(t,[["render",o],["__file","null.html.vue"]]);export{u as default};
