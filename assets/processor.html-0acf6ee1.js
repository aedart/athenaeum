import{_ as c,M as p,p as r,q as u,R as n,N as s,U as e,t as a,a1 as o}from"./framework-efe98465.js";const d={},k=n("h1",{id:"processor",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#processor","aria-hidden":"true"},"#"),a(" Processor")],-1),v=n("p",null,"A http query parameter processor is responsible for creating appropriate query filters, based on its assigned parameter value.",-1),m={class:"table-of-contents"},h=n("h2",{id:"how-it-works",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#how-it-works","aria-hidden":"true"},"#"),a(" How it works")],-1),b=n("p",null,[a("A query parameter is assigned to the processor. It is then responsible for validating the value of that parameter and create one or more query filters, which are stored inside a "),n("code",null,"BuiltFiltersMap"),a(" component.")],-1),f=o(`<h2 id="how-to-create-processor" tabindex="-1"><a class="header-anchor" href="#how-to-create-processor" aria-hidden="true">#</a> How to create processor</h2><p>You can create a new processor by extending the <code>BaseProcessor</code> abstraction.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>BaseProcessor</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>BuiltFiltersMap</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>SearchFilter</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">SimpleSearchProcessor</span> <span class="token keyword">extends</span> <span class="token class-name">BaseProcessor</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">process</span><span class="token punctuation">(</span><span class="token class-name type-declaration">BuiltFiltersMap</span> <span class="token variable">$built</span><span class="token punctuation">,</span> <span class="token keyword type-hint">callable</span> <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// E.g. skip if parameter was submitted with empty value...</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">value</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token keyword">empty</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$built</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>
        
        <span class="token comment">// Create and assign your query filter</span>
        <span class="token variable">$filter</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">SearchFilter</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">add</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">parameter</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token variable">$filter</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// Finally, process the next processor</span>
        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$built</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),g={href:"https://packagist.org/packages/illuminate/pipeline",target:"_blank",rel:"noopener noreferrer"},y=n("code",null,"process()",-1),_=o(`<h2 id="validation" tabindex="-1"><a class="header-anchor" href="#validation" aria-hidden="true">#</a> Validation</h2><p>A received query parameter might contain incorrect or harmful value. You are therefore highly encouraged to validate the received input, before using it in a query filter. The following example shows a possible way to perform validation of a parameter&#39;s value.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Filters<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>InvalidParameter</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">SimpleSearchProcessor</span> <span class="token keyword">extends</span> <span class="token class-name">BaseProcessor</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">process</span><span class="token punctuation">(</span><span class="token class-name type-declaration">BuiltFiltersMap</span> <span class="token variable">$built</span><span class="token punctuation">,</span> <span class="token keyword type-hint">callable</span> <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// Fail if parameter&#39;s value is invalid...</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">value</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token keyword">empty</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">throw</span> <span class="token class-name static-context">InvalidParameter</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;Empty value is not allowed&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>
        
        <span class="token comment">// Create and assign your query filter</span>
        <span class="token variable">$filter</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">SearchFilter</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">add</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">parameter</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span> <span class="token variable">$filter</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// Finally, process the next processor</span>
        <span class="token keyword">return</span> <span class="token variable">$next</span><span class="token punctuation">(</span><span class="token variable">$built</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),w=n("code",null,"InvalidParameterException",-1),x=n("code",null,"ValidationException",-1),$=n("code",null,"422 Unprocessable Entity",-1),F=n("p",null,[a("¹: "),n("em",null,[n("code",null,"Aedart\\Contracts\\Filters\\Exceptions\\InvalidParameterException")])],-1),q=n("h3",{id:"advanced-input-validation",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#advanced-input-validation","aria-hidden":"true"},"#"),a(" Advanced Input Validation")],-1),B={href:"https://laravel.com/docs/8.x/validation#manually-creating-validators",target:"_blank",rel:"noopener noreferrer"},A=n("code",null,"BaseProcessor",-1),M=n("code",null,"getValidatorFactory()",-1),E=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">class</span> <span class="token class-name-definition class-name">SimpleSearchProcessor</span> <span class="token keyword">extends</span> <span class="token class-name">BaseProcessor</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">process</span><span class="token punctuation">(</span><span class="token class-name type-declaration">BuiltFiltersMap</span> <span class="token variable">$built</span><span class="token punctuation">,</span> <span class="token keyword type-hint">callable</span> <span class="token variable">$next</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$validator</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getValidatorFactory</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span>
            <span class="token comment">// The input...</span>
            <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;value&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">value</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>
            
            <span class="token comment">// Validation rules...</span>
            <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;value&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;required|string|min:3|max:150&#39;</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// Obtain valid input... or fail</span>
        <span class="token variable">$validated</span> <span class="token operator">=</span> <span class="token variable">$validator</span><span class="token operator">-&gt;</span><span class="token function">validated</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// ... remaining not shown</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="built-filters-map" tabindex="-1"><a class="header-anchor" href="#built-filters-map" aria-hidden="true">#</a> Built Filters Map</h2><p>The <code>BuiltFiltersMap</code> DTO is intended be used as a temporary placeholder of all the filters that processors created.</p><h3 id="add-filters" tabindex="-1"><a class="header-anchor" href="#add-filters" aria-hidden="true">#</a> Add filters</h3><p>To add one or more filters, from your processor, use the <code>add()</code> method. It accepts two arguments:</p>`,5),P=n("li",null,[n("code",null,"$key"),a(": "),n("em",null,[n("code",null,"string"),a(" key name.")])],-1),I=n("code",null,"filter",-1),S=n("code",null,"Criteria",-1),T=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ... inside your processor&#39;s process method ...</span>

<span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">add</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-parameter&#39;</span><span class="token punctuation">,</span> <span class="token keyword">new</span> <span class="token class-name">SearchFilter</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>If a key already exists, then new filters are simply added to that key. This means that the same key can hold <strong>multiple</strong> query filters.</p><h3 id="obtain-filters" tabindex="-1"><a class="header-anchor" href="#obtain-filters" aria-hidden="true">#</a> Obtain filters</h3><p>To obtain filters, you can use the <code>get()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$filters</span> <span class="token operator">=</span> <span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-parameter&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="obtain-all-filters" tabindex="-1"><a class="header-anchor" href="#obtain-all-filters" aria-hidden="true">#</a> Obtain all filters</h3><p>The <code>all()</code> method will return a list of all added filters.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$filters</span> <span class="token operator">=</span> <span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">all</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h3 id="arbitrary-meta-data" tabindex="-1"><a class="header-anchor" href="#arbitrary-meta-data" aria-hidden="true">#</a> Arbitrary meta data</h3><p>Sometimes, your processor might be required to store additional arbitrary data that other processors can use. If that is the case, then you can use <code>setMeta()</code> and <code>getMeta()</code> methods to do so.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// E.g. inside first processor...</span>
<span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">setMeta</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;use_admin_flag&#39;</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// E.g. inside another processor...</span>
<span class="token variable">$useAdminFlag</span> <span class="token operator">=</span> <span class="token variable">$built</span><span class="token operator">-&gt;</span><span class="token function">getMeta</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;use_admin_flag&#39;</span><span class="token punctuation">,</span> <span class="token constant boolean">false</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>See <code>Aedart\\Contracts\\Filters\\BuiltFiltersMap</code> for additional reference of available methods.</p>`,12);function V(C,L){const t=p("router-link"),l=p("RouterLink"),i=p("ExternalLinkIcon");return r(),u("div",null,[k,v,n("nav",m,[n("ul",null,[n("li",null,[s(t,{to:"#how-it-works"},{default:e(()=>[a("How it works")]),_:1})]),n("li",null,[s(t,{to:"#how-to-create-processor"},{default:e(()=>[a("How to create processor")]),_:1})]),n("li",null,[s(t,{to:"#validation"},{default:e(()=>[a("Validation")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#advanced-input-validation"},{default:e(()=>[a("Advanced Input Validation")]),_:1})])])]),n("li",null,[s(t,{to:"#built-filters-map"},{default:e(()=>[a("Built Filters Map")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#add-filters"},{default:e(()=>[a("Add filters")]),_:1})]),n("li",null,[s(t,{to:"#obtain-filters"},{default:e(()=>[a("Obtain filters")]),_:1})]),n("li",null,[s(t,{to:"#obtain-all-filters"},{default:e(()=>[a("Obtain all filters")]),_:1})]),n("li",null,[s(t,{to:"#arbitrary-meta-data"},{default:e(()=>[a("Arbitrary meta data")]),_:1})])])])])]),h,b,n("p",null,[a("The processor is invoked by a "),s(l,{to:"/archive/v5x/filters/builder.html"},{default:e(()=>[a("builder")]),_:1}),a(", if a http query parameter is matched.")]),f,n("p",null,[a(`In the above shown example, a search filter instance is created and added to the "built filters map" - a data transfer object, which is passed through each processor. Laravel's `),n("a",g,[a("pipeline"),s(i)]),a(" is used behind the scene, for invoking the "),y,a(" method.")]),_,n("p",null,[a("The "),s(l,{to:"/archive/v5x/filters/builder.html"},{default:e(()=>[a("builder")]),_:1}),a(" that runs your processor will automatically handle any exceptions that inherit from "),w,a("¹. Exceptions, of the mentioned kind, will be rethrown as Laravel's "),x,a(", which will result in a "),$,a(" http response in your typical Laravel Application.")]),F,q,n("p",null,[a("You can also use Laravel's "),n("a",B,[a("validator"),s(i)]),a(" and let it do all the heavy lifting. The "),A,a(" offers a reference to the validator factory, via the "),M,a(" method.")]),E,n("ul",null,[P,n("li",null,[I,a(": "),n("em",null,[S,a(" the "),s(l,{to:"/archive/v5x/database/query/criteria.html"},{default:e(()=>[a("query filter")]),_:1}),a(".")])])]),T])}const N=c(d,[["render",V],["__file","processor.html.vue"]]);export{N as default};
