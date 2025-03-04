import{_ as c,M as p,p as i,q as u,R as n,N as a,U as t,t as s,a1 as o}from"./framework-efe98465.js";const r={},d=n("h1",{id:"list-resolver",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#list-resolver","aria-hidden":"true"},"#"),s(" List Resolver")],-1),k=n("p",null,[s("In situations when you need to resolve a list of instances, e.g. a list of filters, the "),n("code",null,"ListResolver"),s(" component can help you out.")],-1),v={class:"table-of-contents"},m=o(`<h2 id="prerequisite" tabindex="-1"><a class="header-anchor" href="#prerequisite" aria-hidden="true">#</a> Prerequisite</h2><p>Laravel&#39;s Service <code>Container</code> must be available in your application.</p><h2 id="example" tabindex="-1"><a class="header-anchor" href="#example" aria-hidden="true">#</a> Example</h2><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>ListResolver</span><span class="token punctuation">;</span>

<span class="token variable">$list</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>SanitizeInput</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ConvertEmptyToNull</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ApplySorting</span><span class="token operator">::</span><span class="token keyword">class</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token comment">// Resolve list of dependencies</span>
<span class="token variable">$filters</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ListResolver</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4),h={href:"https://laravel.com/docs/11.x/container#the-make-method",target:"_blank",rel:"noopener noreferrer"},b=n("code",null,"make()",-1),f=o(`<h2 id="arguments" tabindex="-1"><a class="header-anchor" href="#arguments" aria-hidden="true">#</a> Arguments</h2><p>To provide arguments for a dependency, you can use an array of key-value pairs. Consider the following:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>ListResolver</span><span class="token punctuation">;</span>

<span class="token variable">$list</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>SanitizeInput</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ConvertEmptyToNull</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ApplySorting</span><span class="token operator">::</span><span class="token keyword">class</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;sortBy&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;age&#39;</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;direction&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;desc&#39;</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token comment">// Resolve list of dependencies</span>
<span class="token variable">$filters</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ListResolver</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>In the above example, the <code>ApplySorting</code> component will be instantiated with two arguments; <code>sortBy</code> and <code>direction</code>.</p><h2 id="apply-callback" tabindex="-1"><a class="header-anchor" href="#apply-callback" aria-hidden="true">#</a> Apply Callback</h2><p>You may also provide a custom callback to be invoked, for each resolved instance. This can be done so via the <code>with()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>ListResolver</span><span class="token punctuation">;</span>

<span class="token variable">$list</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>SanitizeInput</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ConvertEmptyToNull</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>ApplySorting</span><span class="token operator">::</span><span class="token keyword">class</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token comment">// Resolve list of dependencies</span>
<span class="token variable">$filters</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">ListResolver</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">with</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token variable">$filter</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token variable">$filter</span><span class="token operator">-&gt;</span><span class="token function">setRequest</span><span class="token punctuation">(</span><span class="token variable">$_GET</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

            <span class="token keyword">return</span> <span class="token variable">$filter</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">Caution</p><p>The callback <em>MUST</em> return a resolved instance.</p></div><h2 id="use-custom-container" tabindex="-1"><a class="header-anchor" href="#use-custom-container" aria-hidden="true">#</a> Use Custom <code>Container</code></h2><p>If you wish to use a custom Service <code>Container</code>, then you can simply provide your custom instance as the constructor&#39;s argument.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>ListResolver</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>IoC<span class="token punctuation">\\</span>Container</span><span class="token punctuation">;</span>

<span class="token variable">$resolver</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">ListResolver</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Container</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,11);function g(y,_){const e=p("router-link"),l=p("ExternalLinkIcon");return i(),u("div",null,[d,k,n("nav",v,[n("ul",null,[n("li",null,[a(e,{to:"#prerequisite"},{default:t(()=>[s("Prerequisite")]),_:1})]),n("li",null,[a(e,{to:"#example"},{default:t(()=>[s("Example")]),_:1})]),n("li",null,[a(e,{to:"#arguments"},{default:t(()=>[s("Arguments")]),_:1})]),n("li",null,[a(e,{to:"#apply-callback"},{default:t(()=>[s("Apply Callback")]),_:1})]),n("li",null,[a(e,{to:"#use-custom-container"},{default:t(()=>[s("Use Custom Container")]),_:1})])])]),m,n("p",null,[s("Behind the scene, the "),n("a",h,[b,a(l)]),s(" method is used to resolve the list of dependencies. This means that even if your components have nested dependencies, then these too will be resolved.")]),f])}const x=c(r,[["render",g],["__file","list-resolver.html.vue"]]);export{x as default};
