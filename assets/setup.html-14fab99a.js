import{_ as i,M as p,p as l,q as o,R as n,N as e,U as t,t as s,a1 as c}from"./framework-efe98465.js";const r={},u=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),d={class:"table-of-contents"},v=c(`<h2 id="outside-laravel" tabindex="-1"><a class="header-anchor" href="#outside-laravel" aria-hidden="true">#</a> Outside Laravel</h2><p>This package will work without any prior setup, also outside regular Laravel applications. However, if you wish to get the most of it, you should create appropriate configuration for the <code>Detector</code>.</p><p>The constructor accepts an array of &quot;profiles&quot;, which define a driver and its options. The following example shows a detector instance with two profiles, a default and a custom.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>MimeTypes<span class="token punctuation">\\</span>Detector</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>MimeTypes<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>FileInfoSampler</span><span class="token punctuation">;</span>

<span class="token variable">$detector</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Detector</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token comment">// A &quot;default&quot; profile...</span>
    <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">FileInfoSampler</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;sample_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">1048576</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;magic_database&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    
    <span class="token comment">// Your custom profile...</span>
    <span class="token string single-quoted-string">&#39;small_file&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name static-context">FileInfoSampler</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;sample_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">512</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;magic_database&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>You can read more about available options in the <a href="./drivers">drivers</a> section.</p><h2 id="inside-laravel" tabindex="-1"><a class="header-anchor" href="#inside-laravel" aria-hidden="true">#</a> Inside Laravel</h2><p>When using this package with Laravel, you can choose to register the package&#39;s service provider and publish a configuration.</p><h3 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h3><p>Register <code>MimeTypesDetectionServiceProvider</code> inside your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>MimeTypes<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>MimeTypesDetectionServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h3><p>Run <code>vendor:publish</code> to publish this package&#39;s configuration.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>The <code>config/mime-types-detection.php</code> configuration will be available in your application.</p><h4 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h4><p>If you are using the <a href="../core">Athenaeum Core Application</a>, then run the following command to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h3><p>Inside the <code>config/mime-types-detection.php</code> file, you can create or change &quot;profiles&quot; for the mime-type detector.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Default Mime-Type detection profiles
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;MIME_TYPE_DETECTOR&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Detector profiles
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;detectors&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>MimeTypes<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>FileInfoSampler</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token comment">// Default sample size in bytes.</span>
                <span class="token string single-quoted-string">&#39;sample_size&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">1048576</span><span class="token punctuation">,</span>

                <span class="token comment">// Magic database to be used.</span>
                <span class="token string single-quoted-string">&#39;magic_database&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,20);function m(k,g){const a=p("router-link");return l(),o("div",null,[u,n("nav",d,[n("ul",null,[n("li",null,[e(a,{to:"#outside-laravel"},{default:t(()=>[s("Outside Laravel")]),_:1})]),n("li",null,[e(a,{to:"#inside-laravel"},{default:t(()=>[s("Inside Laravel")]),_:1}),n("ul",null,[n("li",null,[e(a,{to:"#register-service-provider"},{default:t(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[e(a,{to:"#publish-assets"},{default:t(()=>[s("Publish Assets")]),_:1})]),n("li",null,[e(a,{to:"#configuration"},{default:t(()=>[s("Configuration")]),_:1})])])])])]),v])}const h=i(r,[["render",m],["__file","setup.html.vue"]]);export{h as default};
