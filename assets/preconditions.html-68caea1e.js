import{_ as r,M as i,p,q as d,R as n,t as e,N as a,U as s,a1 as c}from"./framework-efe98465.js";const u={},h=n("h1",{id:"preconditions",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#preconditions","aria-hidden":"true"},"#"),e(" Preconditions")],-1),v=n("code",null,"Evaluator",-1),m={class:"table-of-contents"},f=n("h2",{id:"supported-preconditions",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#supported-preconditions","aria-hidden":"true"},"#"),e(" Supported Preconditions")],-1),k=n("p",null,[e("Unless otherwise specified, the following preconditions are enabled by default in the "),n("code",null,"Evaluator"),e(".")],-1),_=n("h3",{id:"rfc-9110",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#rfc-9110","aria-hidden":"true"},"#"),e(" RFC 9110")],-1),b=n("h3",{id:"extensions",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#extensions","aria-hidden":"true"},"#"),e(" Extensions")],-1),x=c(`<h2 id="disable-extensions" tabindex="-1"><a class="header-anchor" href="#disable-extensions" aria-hidden="true">#</a> Disable Extensions</h2><p>If you do not wish to allow any other kind of preconditions evaluation than those defined by RFC 9110, then you can invoke the <code>useRfc9110Preconditions()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$evaluator</span><span class="token operator">-&gt;</span><span class="token function">useRfc9110Preconditions</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="specify-preconditions" tabindex="-1"><a class="header-anchor" href="#specify-preconditions" aria-hidden="true">#</a> Specify Preconditions</h2>`,4),g={class:"custom-container tip"},y=n("p",{class:"custom-container-title"},"Order of precedence",-1),w={href:"https://httpwg.org/specs/rfc9110.html#precedence",target:"_blank",rel:"noopener noreferrer"},P=c(`<p>To specify what preconditions can be evaluated, set the <code>$preconditions</code> argument in the <code>make()</code> method. Or, use the <code>setPreconditions()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// When creating a new instance...</span>
<span class="token variable">$evaluator</span> <span class="token operator">=</span> <span class="token class-name static-context">Evaluator</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span>
    <span class="token argument-name">request</span><span class="token punctuation">:</span> <span class="token variable">$request</span><span class="token punctuation">,</span>
    <span class="token argument-name">preconditions</span><span class="token punctuation">:</span> <span class="token punctuation">[</span>
        <span class="token class-name static-context">MyCustomPreconditionA</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token keyword">new</span> <span class="token class-name">OtherCustomPrecontion</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Or, when after instance has been instantiated</span>
<span class="token variable">$evaluator</span><span class="token operator">-&gt;</span><span class="token function">setPreconditions</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token class-name static-context">MyCustomPreconditionA</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
    <span class="token keyword">new</span> <span class="token class-name">OtherCustomPrecontion</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Alternatively, if you wish to add a custom precondition to be evaluated after those that are already set (<em>e.g. the default preconditions</em>), then use the <code>addPrecondition()</code> method. Just like when set custom preconditions, the method accepts a string class path or precondition instance as argument.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$evaluator</span><span class="token operator">-&gt;</span><span class="token function">addPrecondition</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">MyCustomPrecondition</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="custom-preconditions" tabindex="-1"><a class="header-anchor" href="#custom-preconditions" aria-hidden="true">#</a> Custom Preconditions</h2>`,5);function C(R,E){const t=i("RouterLink"),o=i("router-link"),l=i("ExternalLinkIcon");return p(),d("div",null,[h,n("p",null,[e("At the heart of the "),v,e(" are the preconditions that can be evaluated, when a request contain such. They are responsible for invoking appropriate "),a(t,{to:"/archive/v7x/etags/evaluator/actions.html"},{default:s(()=>[e("actions")]),_:1}),e(", if applicable, whenever they pass or fail.")]),n("nav",m,[n("ul",null,[n("li",null,[a(o,{to:"#supported-preconditions"},{default:s(()=>[e("Supported Preconditions")]),_:1}),n("ul",null,[n("li",null,[a(o,{to:"#rfc-9110"},{default:s(()=>[e("RFC 9110")]),_:1})]),n("li",null,[a(o,{to:"#extensions"},{default:s(()=>[e("Extensions")]),_:1})])])]),n("li",null,[a(o,{to:"#disable-extensions"},{default:s(()=>[e("Disable Extensions")]),_:1})]),n("li",null,[a(o,{to:"#specify-preconditions"},{default:s(()=>[e("Specify Preconditions")]),_:1})]),n("li",null,[a(o,{to:"#custom-preconditions"},{default:s(()=>[e("Custom Preconditions")]),_:1})])])]),f,k,_,n("ul",null,[n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-match.html"},{default:s(()=>[e("If-Match")]),_:1})]),n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-unmodified-since.html"},{default:s(()=>[e("If-Unmodified-Since")]),_:1})]),n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-none-match.html"},{default:s(()=>[e("If-None-Match")]),_:1})]),n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-modified-since.html"},{default:s(()=>[e("If-Modified-Since")]),_:1})]),n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/rfc9110/if-range.html"},{default:s(()=>[e("If-Range")]),_:1})])]),b,n("ul",null,[n("li",null,[a(t,{to:"/archive/v7x/etags/evaluator/extensions/range.html"},{default:s(()=>[e("Range")]),_:1})])]),x,n("div",g,[y,n("p",null,[e("All preconditions are evaluated in the order that they are given. This means that the default are evaluated in accordance with "),n("a",w,[e("RFC 9110's order of precedence"),a(l)]),e(".")])]),P,n("p",null,[e("See "),a(t,{to:"/archive/v7x/etags/evaluator/extensions/"},{default:s(()=>[e("extensions")]),_:1}),e(" for more information.")])])}const S=r(u,[["render",C],["__file","preconditions.html.vue"]]);export{S as default};
