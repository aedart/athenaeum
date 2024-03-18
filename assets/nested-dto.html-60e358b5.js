import{_ as p,M as t,p as i,q as l,R as s,t as n,N as a,U as c,a1 as r}from"./framework-efe98465.js";const d={},u=s("h1",{id:"nested-dtos",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#nested-dtos","aria-hidden":"true"},"#"),n(" Nested DTOs")],-1),k=s("code",null,"Person",-1),v=s("code",null,"Dto",-1),m={href:"https://laravel.com/docs/5.7/container",target:"_blank",rel:"noopener noreferrer"},b=s("h2",{id:"prerequisite",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#prerequisite","aria-hidden":"true"},"#"),n(" Prerequisite")],-1),h=s("p",null,[n("If you are using the "),s("code",null,"Dto"),n(" component within a typical Laravel application, then you do not have to do anything. A Service Container should already be available.")],-1),g=s("code",null,"Dto",-1),y=s("em",null,"a slightly adapted version of Laravel's Service Container",-1),f=r(`<h2 id="example" tabindex="-1"><a class="header-anchor" href="#example" aria-hidden="true">#</a> Example</h2><p>The following example shows two DTOs; <code>Address</code> and <code>Person</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Dto</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Address</span> <span class="token keyword">extends</span> <span class="token class-name">Dto</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token variable">$street</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;&#39;</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">setStreet</span><span class="token punctuation">(</span><span class="token operator">?</span><span class="token keyword type-hint">string</span> <span class="token variable">$street</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">street</span> <span class="token operator">=</span> <span class="token variable">$street</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getStreet</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token operator">?</span><span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">street</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token comment">// ------------------------------------------------ //</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">Person</span> <span class="token keyword">extends</span> <span class="token class-name">Dto</span> <span class="token keyword">implements</span> <span class="token class-name">PersonInterface</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token variable">$name</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;&#39;</span><span class="token punctuation">;</span>
    
    <span class="token keyword">protected</span> <span class="token variable">$age</span> <span class="token operator">=</span> <span class="token number">0</span><span class="token punctuation">;</span>
 
    <span class="token keyword">protected</span> <span class="token variable">$address</span> <span class="token operator">=</span> <span class="token constant">null</span><span class="token punctuation">;</span>
 
    <span class="token comment">// ... getters and setters for name and age not shown ... //</span>

     <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">setAddress</span><span class="token punctuation">(</span><span class="token operator">?</span><span class="token class-name type-declaration">Address</span> <span class="token variable">$address</span><span class="token punctuation">)</span>
     <span class="token punctuation">{</span>
         <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">address</span> <span class="token operator">=</span> <span class="token variable">$address</span><span class="token punctuation">;</span>
     <span class="token punctuation">}</span>
     
     <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">getAddress</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token operator">?</span><span class="token class-name return-type">Address</span>
     <span class="token punctuation">{</span>
         <span class="token keyword">return</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">address</span><span class="token punctuation">;</span>
     <span class="token punctuation">}</span>
<span class="token punctuation">}</span>

<span class="token comment">// ------------------------------------------------ //</span>
<span class="token comment">// ... elsewhere in your application ... //</span>

<span class="token comment">// Data for your Person DTO</span>
<span class="token variable">$data</span> <span class="token operator">=</span> <span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Arial Jackson&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;age&#39;</span> <span class="token operator">=&gt;</span> <span class="token number">42</span><span class="token punctuation">,</span>
    
    <span class="token comment">// Notice that we are NOT passing in an instance of Address, but an array instead!</span>
    <span class="token string single-quoted-string">&#39;address&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
        <span class="token string single-quoted-string">&#39;street&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Somewhere str. 44&#39;</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token variable">$person</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Person</span><span class="token punctuation">(</span><span class="token variable">$data</span><span class="token punctuation">)</span><span class="token punctuation">;</span>                                    
<span class="token variable">$address</span> <span class="token operator">=</span> <span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token function">getAddress</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3),_={href:"http://laravel.com/docs/5.5/container",target:"_blank",rel:"noopener noreferrer"},w=s("p",null,[n("Furthermore, the default "),s("code",null,"Dto"),n(" abstraction will attempt to automatically populate that instance.")],-1);function x($,D){const e=t("ExternalLinkIcon"),o=t("RouterLink");return i(),l("div",null,[u,s("p",null,[n("Imagine that your "),k,n(" DTO accepts more complex properties, e.g. an address DTO. Normally, you would either manually create the nested DTO or perhaps use some kind of factory to achieve the same. However, the "),v,n(" abstraction comes with "),s("a",m,[n("Laravel's Service Container"),a(e)]),n(", meaning that it will automatically attempt to resolve dependencies.")]),b,h,s("p",null,[n("If you are using the "),g,n(" outside a Laravel application, then you must ensure that a Service Container has been initialised. Consider using this package's "),a(o,{to:"/archive/v1x/container/"},{default:c(()=>[n("Service Container")]),_:1}),n(" ("),y,n(").")]),f,s("p",null,[n("In the above example, "),s("a",_,[n("Laravel's Service Container"),a(e)]),n(" attempts to find and resolve instances that are expected.")]),w])}const A=p(d,[["render",x],["__file","nested-dto.html.vue"]]);export{A as default};
