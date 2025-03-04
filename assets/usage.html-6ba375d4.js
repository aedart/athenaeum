import{_ as l,M as o,p as r,q as c,R as n,N as s,U as e,t as a,a1 as i}from"./framework-efe98465.js";const u={},d=n("h1",{id:"how-to-use",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#how-to-use","aria-hidden":"true"},"#"),a(" How to use")],-1),v=n("p",null,[a("At the top level, a "),n("code",null,"Manager"),a(" is responsible for keeping track of your exporters.")],-1),k={class:"table-of-contents"},m=i(`<h2 id="obtain-manager" tabindex="-1"><a class="header-anchor" href="#obtain-manager" aria-hidden="true">#</a> Obtain Manager</h2><p>The translation exporter <code>Manger</code> can be obtained via the <code>TranslationsExporterManagerTrait</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Translation<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>TranslationsExporterManagerTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyController</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">TranslationsExporterManagerTrait</span><span class="token punctuation">;</span>
    
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">index</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$manager</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getTranslationsExporterManager</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// ..remaining not shown...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Once you have your manager, you can request an <code>Exporter</code> instance, which will perform the actual exporting of translations.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$exporter</span> <span class="token operator">=</span> <span class="token variable">$manager</span><span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Default profile</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>To obtain a specific <code>Exporter</code>, specify the profile name as argument.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$exporter</span> <span class="token operator">=</span> <span class="token variable">$manager</span><span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;lang_js&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="export-translations" tabindex="-1"><a class="header-anchor" href="#export-translations" aria-hidden="true">#</a> Export Translations</h2><p>To export the application&#39;s translations, invoke the <code>export()</code> method. It accepts the following arguments:</p><ul><li><code>string|array $locales</code> (<em>optional</em>) Locales to export. Wildcard (<em>*</em>) = all locales.</li><li><code>string|array $groups</code> (<em>optional</em>) Groups to export. Wildcard (<em>*</em>) = all groups, incl. namespaced groups, e.g. <code>&#39;courier::messages&#39;</code>.</li></ul><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// All available translations, for all locales...</span>
<span class="token variable">$all</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// English translations only...</span>
<span class="token variable">$englishOnly</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// En-uk, of the auth and validation groups</span>
<span class="token variable">$uk</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en-uk&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;validation&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Namespaced group (from a package)...</span>
<span class="token variable">$acme</span> <span class="token operator">=</span> <span class="token variable">$exporter</span><span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;be&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;acme::users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,11),g=n("code",null,"export()",-1),h=i(`<h2 id="paths-and-translations" tabindex="-1"><a class="header-anchor" href="#paths-and-translations" aria-hidden="true">#</a> Paths and Translations</h2><p>Available locales and groups are automatically detected, based on the <code>paths</code> option (<em>in your <code>config/translations-exporter.php</code></em>), as well as registered namespaced translations and paths to JSON files, in Laravel&#39;s translation loader.</p><p>If you wish to export translations from 3rd party packages, then you have the following options:</p><ol><li>Register 3rd party service provider to load translations.</li><li>Publish packages&#39; resource (<em>if translations are published</em>)</li><li>Or, manual registration of translations (<em>see below</em>)</li></ol><p>To use translations from packages, without having to register their service providers, you can register them in the configuration:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>
    <span class="token comment">// ...previous not shown...</span>
    
    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Namespaces and Json
    |--------------------------------------------------------------------------
    |
    | Register namespaced translations and paths to JSON translations. Use this
    | when you want to use 3rd part translations without having to register
    | their service providers.
    */</span>

    <span class="token string single-quoted-string">&#39;namespaces&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;acme&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">realpath</span><span class="token punctuation">(</span><span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../vendor/acme/package/lang&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string single-quoted-string">&#39;json&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token function">realpath</span><span class="token punctuation">(</span><span class="token constant">__DIR__</span> <span class="token operator">.</span> <span class="token string single-quoted-string">&#39;/../vendor/acme/package/lang&#39;</span><span class="token punctuation">)</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token comment">// ...remaining not shown ...</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Consequently, when you manually register namespaced translations and paths to JSON translations, then these will be made available in your application!</p>`,7);function b(f,x){const t=o("router-link"),p=o("RouterLink");return r(),c("div",null,[d,v,n("nav",k,[n("ul",null,[n("li",null,[s(t,{to:"#obtain-manager"},{default:e(()=>[a("Obtain Manager")]),_:1})]),n("li",null,[s(t,{to:"#export-translations"},{default:e(()=>[a("Export Translations")]),_:1})]),n("li",null,[s(t,{to:"#paths-and-translations"},{default:e(()=>[a("Paths and Translations")]),_:1})])])]),m,n("p",null,[a("The output of the "),g,a(" method depends on the chosen profile's "),s(p,{to:"/archive/v8x/translation/exporters/drivers/"},{default:e(()=>[a("driver")]),_:1}),a(".")]),h])}const y=l(u,[["render",b],["__file","usage.html.vue"]]);export{y as default};
