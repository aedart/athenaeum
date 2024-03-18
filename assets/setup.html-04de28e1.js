import{_ as i,M as p,p as o,q as l,R as n,N as e,U as t,t as s,a1 as c}from"./framework-efe98465.js";const u={},r=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),d={class:"table-of-contents"},v=c(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>In your <code>config/app.php</code>, register <code>AntivirusServiceProvider</code></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoload Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>AntivirusServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets-optional" tabindex="-1"><a class="header-anchor" href="#publish-assets-optional" aria-hidden="true">#</a> Publish Assets (optional)</h2><p>Run <code>vendor:publish</code> to publish this package&#39;s configuration.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>After the command has completed, you should see <code>config/antivirus.php</code> in your application.</p><h3 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h3><p>If you are using the <a href="../../core">Athenaeum Core Application</a>, then run the following command to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>The <code>config/antivirus.php</code> file contains the various antivirus profiles. Configure them as you see fit.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>BufferSizes</span><span class="token punctuation">;</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Default Antivirus Scanner
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;default_scanner&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;DEFAULT_ANTIVIRUS_SCANNER&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Scanner Profiles
    |--------------------------------------------------------------------------
    |
    | List of available antivirus scanner profiles
    */</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>ClamAv</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;socket&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;CLAMAV_SOCKET&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;unix:///var/run/clamav/clamd.ctl&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;socket_timeout&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;CLAMAV_SOCKET_TIMEOUT&#39;</span><span class="token punctuation">,</span> <span class="token number">2</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;timeout&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;CLAMAV_SCAN_TIMEOUT&#39;</span><span class="token punctuation">,</span> <span class="token number">30</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;chunk_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;CLAMAV_STREAM_CHUNK_SIZE&#39;</span><span class="token punctuation">,</span> <span class="token class-name static-context">BufferSizes</span><span class="token operator">::</span><span class="token constant">BUFFER_1MB</span> <span class="token operator">*</span> <span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>

        <span class="token string single-quoted-string">&#39;null&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Antivirus<span class="token punctuation">\\</span>Scanners<span class="token punctuation">\\</span>NullScanner</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;should_pass&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant boolean">false</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,13);function k(m,g){const a=p("router-link");return o(),l("div",null,[r,n("nav",d,[n("ul",null,[n("li",null,[e(a,{to:"#register-service-provider"},{default:t(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[e(a,{to:"#publish-assets-optional"},{default:t(()=>[s("Publish Assets (optional)")]),_:1}),n("ul",null,[n("li",null,[e(a,{to:"#publish-assets-for-athenaeum-core-application"},{default:t(()=>[s("Publish Assets for Athenaeum Core Application")]),_:1})])])]),n("li",null,[e(a,{to:"#configuration"},{default:t(()=>[s("Configuration")]),_:1})])])]),v])}const h=i(u,[["render",k],["__file","setup.html.vue"]]);export{h as default};
