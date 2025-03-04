import{_ as t,M as l,p as o,q as r,R as n,N as e,U as i,t as s,a1 as p}from"./framework-efe98465.js";const c={},d=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),u={class:"table-of-contents"},v=p(`<h2 id="outside-laravel" tabindex="-1"><a class="header-anchor" href="#outside-laravel" aria-hidden="true">#</a> Outside Laravel</h2><p>The stream components will work, as-is, even outside a regular Laravel application. However, depending on your needs, you may have to manually configure a few things before able to achieve desired behaviour. Where such is relevant, the documentation will make it clear.</p><h2 id="inside-laravel" tabindex="-1"><a class="header-anchor" href="#inside-laravel" aria-hidden="true">#</a> Inside Laravel</h2><p>To gain the most of this package, you should register its service provider and publish its assets.</p><h3 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h3><p>In your <code>config/app.php</code>, register <code>StreamServiceProvider</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>StreamServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h3><p>Run <code>vendor:publish</code> to publish this package&#39;s configuration.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>You should now have a new <code>config/streams.php</code> configuration available in your application.</p><h4 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h4><p>When using this package with an <a href="../core">Athenaeum Core Application</a>, then run the following command to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h3><p>The <code>config/streams.php</code> configuration allows you to add and customise different &quot;profiles&quot; for the stream &quot;locking&quot; and &quot;transaction&quot; mechanisms. Feel free to thinker with these as you see fit.</p><p><em>More information about the mentioned mechanisms are covered in later sections.</em></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Default Stream profiles
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;default_lock&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;STREAM_LOCK&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

    <span class="token string single-quoted-string">&#39;default_transaction&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;STREAM_TRANSACTION&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

    <span class="token comment">/*
     |--------------------------------------------------------------------------
     | Lock profiles
     |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;locks&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Streams<span class="token punctuation">\\</span>Locks<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>FLockDriver</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;sleep&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">10_000</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;fail_on_timeout&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant boolean">true</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
    
    <span class="token comment">// ... remaining not shown...</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,18);function m(h,k){const a=l("router-link");return o(),r("div",null,[d,n("nav",u,[n("ul",null,[n("li",null,[e(a,{to:"#outside-laravel"},{default:i(()=>[s("Outside Laravel")]),_:1})]),n("li",null,[e(a,{to:"#inside-laravel"},{default:i(()=>[s("Inside Laravel")]),_:1}),n("ul",null,[n("li",null,[e(a,{to:"#register-service-provider"},{default:i(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[e(a,{to:"#publish-assets"},{default:i(()=>[s("Publish Assets")]),_:1})]),n("li",null,[e(a,{to:"#configuration"},{default:i(()=>[s("Configuration")]),_:1})])])])])]),v])}const b=t(c,[["render",m],["__file","setup.html.vue"]]);export{b as default};
