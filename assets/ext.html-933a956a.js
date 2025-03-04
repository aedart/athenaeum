import{_ as c,M as o,p as r,q as l,R as n,N as a,U as t,t as s,a1 as p}from"./framework-efe98465.js";const d={},u=n("h1",{id:"extending-core-application",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#extending-core-application","aria-hidden":"true"},"#"),s(" Extending Core Application")],-1),k=n("p",null,"In this chapter, you will find a few hints if you choose to extend the Core Application.",-1),v={class:"table-of-contents"},m=p(`<h2 id="core-service-providers" tabindex="-1"><a class="header-anchor" href="#core-service-providers" aria-hidden="true">#</a> Core Service Providers</h2><p>As soon as you instantiate a new Application instance, it&#39;s core service providers are registered - <em>but NOT booted!</em> Some of these service providers are very essential and the application might not work as expected, without them. Should you wish to adapt the list of core service providers, overwrite the <code>getCoreServiceProviders()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Application</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">AcmeApplication</span> <span class="token keyword">extends</span> <span class="token class-name">Application</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getCoreServiceProviders</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token class-name static-context">CoreServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">ExceptionHandlerServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">NativeFilesystemServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">EventServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">ListenersViaConfigServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">ConfigServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">ConfigLoaderServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    
            <span class="token comment">// ... etc</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
    
    <span class="token comment">// ... remaining not shown ...   </span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="core-bootstrappers" tabindex="-1"><a class="header-anchor" href="#core-bootstrappers" aria-hidden="true">#</a> Core Bootstrappers</h2><p>A &quot;bootstrapper&quot; is a component that is able to perform some kind of &quot;initial startup&quot; logic. It is what sets the entire application in motion. Bootstrappers are processed when you invoke the <code>bootstrapWith()</code> method (<em>automatically invoked by the application&#39;s <code>run()</code> method</em>). Furthermore, they are <em>processed after the core service providers have registered!</em></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$app</span><span class="token operator">-&gt;</span><span class="token function">run</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// All bootstrappers are processed...</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="create-custom-bootstrapper" tabindex="-1"><a class="header-anchor" href="#create-custom-bootstrapper" aria-hidden="true">#</a> Create Custom Bootstrapper</h3><p>To create your own custom bootstrapper, you need to implement the <code>CanBeBootstrapped</code> interface. The following examples shows a very simple bootstrapper, which is used to set the default timezone.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Bootstrappers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Application</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>CanBeBootstrapped</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>Config<span class="token punctuation">\\</span>ConfigTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">SetDefaultTimezone</span> <span class="token keyword">implements</span> <span class="token class-name">CanBeBootstrapped</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ConfigTrait</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">bootstrap</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Application</span> <span class="token variable">$application</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">void</span>
    <span class="token punctuation">{</span>
        <span class="token function">date_default_timezone_set</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getConfig</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;app.timezone&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;UTC&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="highlight-lines"><br><br><br><br><br><div class="highlight-line"> </div><br><br><br><br><br><br><br><br><br><br><br></div><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="overwrite-core-bootstrappers" tabindex="-1"><a class="header-anchor" href="#overwrite-core-bootstrappers" aria-hidden="true">#</a> Overwrite Core Bootstrappers</h3><p>To use your custom bootstrappers, you need to overwrite the <code>getCoreBootstrappers()</code> method. Similar to the <code>getCoreServiceProviders()</code> method, this method returns an order list of class paths to the application&#39;s bootstrappers.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Core<span class="token punctuation">\\</span>Application</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">AcmeApplication</span> <span class="token keyword">extends</span> <span class="token class-name">Application</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getCoreBootstrappers</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token class-name static-context">DetectAndLoadEnvironment</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">LoadConfiguration</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">SetDefaultTimezone</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">SetExceptionHandling</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    
            <span class="token comment">// ... etc</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
    
    <span class="token comment">// ... remaining not shown ...   </span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="application-is-a-service-container" tabindex="-1"><a class="header-anchor" href="#application-is-a-service-container" aria-hidden="true">#</a> Application is a Service Container</h2>`,13),h={href:"https://laravel.com/docs/10.x/container",target:"_blank",rel:"noopener noreferrer"},b=n("em",null,"But not before those service have been registered!",-1),g=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Somewhere inside your extended Core Application</span>
<span class="token variable">$config</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;config&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Might fail, if Config Service hasn&#39;t registered!</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><p>It is advisable that you keep your logic simple. If possible, try to encapsulate your needs into either service providers or bootstrappers. Otherwise, you risk of adding too much complexity, inside the actual application.</p>`,2);function f(y,w){const e=o("router-link"),i=o("ExternalLinkIcon");return r(),l("div",null,[u,k,n("nav",v,[n("ul",null,[n("li",null,[a(e,{to:"#core-service-providers"},{default:t(()=>[s("Core Service Providers")]),_:1})]),n("li",null,[a(e,{to:"#core-bootstrappers"},{default:t(()=>[s("Core Bootstrappers")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#create-custom-bootstrapper"},{default:t(()=>[s("Create Custom Bootstrapper")]),_:1})]),n("li",null,[a(e,{to:"#overwrite-core-bootstrappers"},{default:t(()=>[s("Overwrite Core Bootstrappers")]),_:1})])])]),n("li",null,[a(e,{to:"#application-is-a-service-container"},{default:t(()=>[s("Application is a Service Container")]),_:1})])])]),m,n("p",null,[s("Just like Laravel's Foundation Application, the Athenaeum Core Application extends the "),n("a",h,[s("Service Container"),a(i)]),s(". This means that, you can gain access to services and components. "),b]),g])}const C=c(d,[["render",f],["__file","ext.html.vue"]]);export{C as default};
