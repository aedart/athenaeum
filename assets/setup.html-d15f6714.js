import{_ as c,M as t,p as r,q as p,R as n,N as e,U as i,t as s,a1 as l}from"./framework-efe98465.js";const d={},u=n("h1",{id:"setup",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),s(" Setup")],-1),v={class:"table-of-contents"},m=l(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>CircuitBreakerServiceProvider</code> inside your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Circuits<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>CircuitBreakerServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="publish-assets" tabindex="-1"><a class="header-anchor" href="#publish-assets" aria-hidden="true">#</a> Publish Assets</h2><p>Run <code>vendor:publish</code> to publish package&#39;s assets.</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php artisan vendor:publish
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>Once completed, the following configuration file should be available inside your <code>config/</code> directory:</p><ul><li><code>circuit-breakers</code></li></ul><h3 id="publish-assets-for-athenaeum-core-application" tabindex="-1"><a class="header-anchor" href="#publish-assets-for-athenaeum-core-application" aria-hidden="true">#</a> Publish Assets for Athenaeum Core Application</h3><p>When using <a href="../../core">Athenaeum Core Application</a>, run <code>vendor:publish-all</code> to publish assets:</p><div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code>php <span class="token punctuation">{</span>your-cli-app<span class="token punctuation">}</span> vendor:publish-all
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="configuration" tabindex="-1"><a class="header-anchor" href="#configuration" aria-hidden="true">#</a> Configuration</h2><p>The <code>config/circuit-breakers.php</code> configuration file, is intended to contain a list of &quot;services&quot;. Each service has a list of settings (<em>options</em>) for it&#39;s corresponding circuit breaker instance. Add or change these settings as you see fit.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token string single-quoted-string">&#39;services&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;weather_service&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

            <span class="token comment">/*
             * Name of store to use
             */</span>
            <span class="token string single-quoted-string">&#39;store&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;default&#39;</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Maximum amount of times that a callback should
             * be attempted
             */</span>
            <span class="token string single-quoted-string">&#39;retries&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">3</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Amount of milliseconds to wait before each attempt
             */</span>
            <span class="token string single-quoted-string">&#39;delay&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">100</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Maximum amount of failures before circuit breaker
             * must trip (change state to &quot;open&quot;)
             */</span>
            <span class="token string single-quoted-string">&#39;failure_threshold&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">10</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Grace period duration.
             *
             * The amount of seconds to wait before circuit breaker can
             * attempt to change state to &quot;half open&quot;, after failure
             * threshold has been reached.
             */</span>
            <span class="token string single-quoted-string">&#39;grace_period&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">10</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Timezone
             */</span>
            <span class="token string single-quoted-string">&#39;timezone&#39;</span> <span class="token operator">=&gt;</span> <span class="token function">env</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;TIMEZONE&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;UTC&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>

            <span class="token comment">/*
             * Time-to-live (ttl) for a state
             *
             * Duration in seconds. When none given, it defaults to
             * store&#39;s ttl.
             */</span>
            <span class="token string single-quoted-string">&#39;state_ttl&#39;</span> <span class="token operator">=&gt;</span> <span class="token constant">null</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="store-configuration" tabindex="-1"><a class="header-anchor" href="#store-configuration" aria-hidden="true">#</a> Store Configuration</h3><p>Each Circuit Breaker uses a <code>Store</code> to keep track of it&#39;s state (<em>closed, open, half-open</em>). In your configuration, you can specify the profile-name of the store to use. Additional store configuration can be specified in your configuration file (<code>config/circuit-breakers.php</code>).</p>`,16),b={class:"custom-container warning"},k=n("p",{class:"custom-container-title"},"WARNING",-1),h={href:"https://laravel.com/docs/9.x/cache#atomic-locks",target:"_blank",rel:"noopener noreferrer"},g=n("code",null,"LockProvider",-1),f=l(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>
    <span class="token comment">// ... previous not shown ...</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Stores
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;stores&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Circuits<span class="token punctuation">\\</span>Stores<span class="token punctuation">\\</span>CacheStore</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                <span class="token comment">/*
                 * Name of Laravel Cache Store to use
                 *
                 * WARNING: Cache Store MUST inherit from LockProvider or
                 * it cannot be used.
                 *
                 * @see \\Illuminate\\Contracts\\Cache\\LockProvider
                 */</span>
                <span class="token string single-quoted-string">&#39;cache-store&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;redis&#39;</span><span class="token punctuation">,</span>

                <span class="token comment">/*
                 * Default time-to-live (ttl) for a state.
                 */</span>
                <span class="token string single-quoted-string">&#39;ttl&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">3600</span><span class="token punctuation">,</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function _(q,x){const a=t("router-link"),o=t("ExternalLinkIcon");return r(),p("div",null,[u,n("nav",v,[n("ul",null,[n("li",null,[e(a,{to:"#register-service-provider"},{default:i(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[e(a,{to:"#publish-assets"},{default:i(()=>[s("Publish Assets")]),_:1}),n("ul",null,[n("li",null,[e(a,{to:"#publish-assets-for-athenaeum-core-application"},{default:i(()=>[s("Publish Assets for Athenaeum Core Application")]),_:1})])])]),n("li",null,[e(a,{to:"#configuration"},{default:i(()=>[s("Configuration")]),_:1}),n("ul",null,[n("li",null,[e(a,{to:"#store-configuration"},{default:i(()=>[s("Store Configuration")]),_:1})])])])])]),m,n("div",b,[k,n("p",null,[s("Currently, only cache stores that inherit from "),n("a",h,[g,e(o)]),s(" can be used.")])]),f])}const y=c(d,[["render",_],["__file","setup.html.vue"]]);export{y as default};
