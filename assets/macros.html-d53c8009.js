import{_ as l,M as p,p as i,q as r,R as n,t as a,N as s,U as o,a1 as c}from"./framework-efe98465.js";const d={},u=n("h1",{id:"request-response-macros",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#request-response-macros","aria-hidden":"true"},"#"),a(" Request / Response Macros")],-1),h={href:"https://laravel.com/docs/11.x/responses#response-macros",target:"_blank",rel:"noopener noreferrer"},k={class:"table-of-contents"},m=n("h2",{id:"request-macros",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#request-macros","aria-hidden":"true"},"#"),a(" Request Macros")],-1),f=n("h3",{id:"ifmatchetags",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#ifmatchetags","aria-hidden":"true"},"#"),a(),n("code",null,"ifMatchEtags()")],-1),g=n("code",null,"ifMatchEtags()",-1),v=n("code",null,"ETag",-1),_={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Match",target:"_blank",rel:"noopener noreferrer"},b=n("code",null,"If-Match",-1),w=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">ifMatchEtags</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">isNotEmpty</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ...remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="ifnonematchetags" tabindex="-1"><a class="header-anchor" href="#ifnonematchetags" aria-hidden="true">#</a> <code>ifNoneMatchEtags()</code></h3>`,2),T=n("code",null,"ETag",-1),E={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-None-Match",target:"_blank",rel:"noopener noreferrer"},y=n("code",null,"If-None-Match",-1),x=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">ifNoneMatchEtags</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">isEmpty</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ...remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="ifmodifiedsincedate" tabindex="-1"><a class="header-anchor" href="#ifmodifiedsincedate" aria-hidden="true">#</a> <code>ifModifiedSinceDate()</code></h3>`,2),R={href:"https://www.php.net/manual/en/class.datetimeinterface",target:"_blank",rel:"noopener noreferrer"},q=n("code",null,"DateTime",-1),M={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Modified-Since",target:"_blank",rel:"noopener noreferrer"},H=n("code",null,"If-Modified-Since",-1),S=n("code",null,"null",-1),$=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$datetime</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">ifModifiedSinceDate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token operator">!</span><span class="token function">is_null</span><span class="token punctuation">(</span><span class="token variable">$datetime</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ...remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1),I=n("strong",null,"Note",-1),D=n("code",null,"null",-1),N=n("code",null,"GET",-1),U=n("code",null,"HEAD",-1),C=n("code",null,"If-None-Match",-1),P={href:"https://httpwg.org/specs/rfc9110.html#field.if-modified-since",target:"_blank",rel:"noopener noreferrer"},z=n("h3",{id:"ifunmodifiedsincedate",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#ifunmodifiedsincedate","aria-hidden":"true"},"#"),a(),n("code",null,"ifUnmodifiedSinceDate()")],-1),W={href:"https://www.php.net/manual/en/class.datetimeinterface",target:"_blank",rel:"noopener noreferrer"},F=n("code",null,"DateTime",-1),G={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Unmodified-Since",target:"_blank",rel:"noopener noreferrer"},O=n("code",null,"If-Unmodified-Since",-1),V=n("code",null,"null",-1),A=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$datetime</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">ifUnmodifiedSinceDate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$datetime</span> <span class="token keyword">instanceof</span> <span class="token class-name class-name-fully-qualified"><span class="token punctuation">\\</span>DateTimeInterface</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ...remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1),B=n("strong",null,"Note",-1),L=n("code",null,"null",-1),j=n("code",null,"If-Match",-1),J={href:"https://httpwg.org/specs/rfc9110.html#field.if-unmodified-since",target:"_blank",rel:"noopener noreferrer"},K=n("h3",{id:"ifrangeetagordate",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#ifrangeetagordate","aria-hidden":"true"},"#"),a(),n("code",null,"ifRangeEtagOrDate()")],-1),Q={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/If-Range",target:"_blank",rel:"noopener noreferrer"},X=n("code",null,"If-Range",-1),Y={href:"https://httpwg.org/specs/rfc9110.html#http.date",target:"_blank",rel:"noopener noreferrer"},Z={href:"https://httpwg.org/specs/rfc9110.html#field.etag",target:"_blank",rel:"noopener noreferrer"},nn=n("code",null,"ifRangeEtagOrDate()",-1),an={href:"https://www.php.net/manual/en/class.datetimeinterface",target:"_blank",rel:"noopener noreferrer"},sn=n("code",null,"DateTime",-1),en=n("li",null,[n("code",null,"ETag"),a(" instance")],-1),tn=n("code",null,"null",-1),on=n("code",null,"If-Range",-1),cn=n("code",null,"Range",-1),pn={href:"https://httpwg.org/specs/rfc9110.html#field.if-range",target:"_blank",rel:"noopener noreferrer"},ln=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>ETag</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">ifRangeEtagOrDate</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$value</span> <span class="token keyword">instanceof</span> <span class="token class-name">ETag</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ... not shown ...</span>
<span class="token punctuation">}</span> <span class="token keyword">elseif</span> <span class="token punctuation">(</span><span class="token variable">$value</span> <span class="token keyword">instanceof</span> <span class="token class-name class-name-fully-qualified"><span class="token punctuation">\\</span>DateTimeInterface</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token comment">// ... not shown ...</span>
<span class="token punctuation">}</span> <span class="token keyword">else</span> <span class="token punctuation">{</span>
    <span class="token comment">// &quot;If-Range&quot; was not requested, or &quot;Range&quot; header was not set...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="response-macros" tabindex="-1"><a class="header-anchor" href="#response-macros" aria-hidden="true">#</a> Response Macros</h2><h3 id="withetag" tabindex="-1"><a class="header-anchor" href="#withetag" aria-hidden="true">#</a> <code>withEtag()</code></h3>`,3),rn=n("code",null,"withEtag()",-1),dn={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/ETag",target:"_blank",rel:"noopener noreferrer"},un=n("code",null,"ETag",-1),hn=n("code",null,"ETag",-1),kn=n("strong",null,"Note",-1),mn={href:"https://symfony.com/doc/current/components/http_foundation.html#managing-the-http-cache",target:"_blank",rel:"noopener noreferrer"},fn=n("code",null,"setEtag()",-1),gn=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Facades<span class="token punctuation">\\</span>Generator</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Response</span><span class="token punctuation">;</span>

<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeStrong</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">withEtag</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="withoutetag" tabindex="-1"><a class="header-anchor" href="#withoutetag" aria-hidden="true">#</a> <code>withoutEtag()</code></h3><p>If you need to remove a response&#39;s <code>ETag</code> Http header, use the <code>withoutEtag()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">withEtag</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Later in your application - remove ETag</span>
<span class="token variable">$response</span><span class="token operator">-&gt;</span><span class="token function">withoutEtag</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="withcache" tabindex="-1"><a class="header-anchor" href="#withcache" aria-hidden="true">#</a> <code>withCache()</code></h3>`,5),vn=n("code",null,"withCache()",-1),_n={href:"https://symfony.com/doc/current/components/http_foundation.html#managing-the-http-cache",target:"_blank",rel:"noopener noreferrer"},bn=n("code",null,"setCache()",-1),wn=n("code",null,"ETag",-1),Tn=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeStrong</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">Response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">withCache</span><span class="token punctuation">(</span>
        <span class="token argument-name">etag</span><span class="token punctuation">:</span> <span class="token variable">$etag</span><span class="token punctuation">,</span>
        <span class="token argument-name">lastModified</span><span class="token punctuation">:</span> <span class="token function">now</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">addHours</span><span class="token punctuation">(</span><span class="token number">3</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">addSeconds</span><span class="token punctuation">(</span><span class="token number">43</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
        <span class="token keyword">private</span><span class="token punctuation">:</span> <span class="token constant boolean">true</span>
    <span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function En(yn,xn){const e=p("ExternalLinkIcon"),t=p("router-link");return i(),r("div",null,[u,n("p",null,[a("Etags and precondition evaluator components depend on a few "),n("a",h,[a("Http Request & Response Macros"),s(e)]),a(". These are automatically installed by this package's service provider. The following highlights the macros that are installed.")]),n("nav",k,[n("ul",null,[n("li",null,[s(t,{to:"#request-macros"},{default:o(()=>[a("Request Macros")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#ifmatchetags"},{default:o(()=>[a("ifMatchEtags()")]),_:1})]),n("li",null,[s(t,{to:"#ifnonematchetags"},{default:o(()=>[a("ifNoneMatchEtags()")]),_:1})]),n("li",null,[s(t,{to:"#ifmodifiedsincedate"},{default:o(()=>[a("ifModifiedSinceDate()")]),_:1})]),n("li",null,[s(t,{to:"#ifunmodifiedsincedate"},{default:o(()=>[a("ifUnmodifiedSinceDate()")]),_:1})]),n("li",null,[s(t,{to:"#ifrangeetagordate"},{default:o(()=>[a("ifRangeEtagOrDate()")]),_:1})])])]),n("li",null,[s(t,{to:"#response-macros"},{default:o(()=>[a("Response Macros")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#withetag"},{default:o(()=>[a("withEtag()")]),_:1})]),n("li",null,[s(t,{to:"#withoutetag"},{default:o(()=>[a("withoutEtag()")]),_:1})]),n("li",null,[s(t,{to:"#withcache"},{default:o(()=>[a("withCache()")]),_:1})])])])])]),m,f,n("p",null,[a("The "),g,a(" returns a collection or "),v,a(" instances, from the "),n("a",_,[b,a(" Http header"),s(e)]),a(".")]),w,n("p",null,[a("Returns a collection or "),T,a(" instances, from the "),n("a",E,[y,a(" Http header"),s(e)]),a(".")]),x,n("p",null,[a("Returns a "),n("a",R,[q,s(e)]),a(" instance of the "),n("a",M,[H,a(" Http header"),s(e)]),a(", or "),S,a(" if not set.")]),$,n("p",null,[I,a(": "),n("em",null,[a("The method will return "),D,a(" if the HTTP Method is not "),N,a(" or "),U,a(", or if the request contains an "),C,a(" header. See "),n("a",P,[a("RFC-9110"),s(e)]),a(" for additional information.")])]),z,n("p",null,[a("Returns a "),n("a",W,[F,s(e)]),a(" instance of the "),n("a",G,[O,a(" Http header"),s(e)]),a(", or "),V,a(" if not set.")]),A,n("p",null,[B,a(": "),n("em",null,[a("The method will return "),L,a(" if the request contains an "),j,a(" header. See "),n("a",J,[a("RFC-9110"),s(e)]),a(" for additional information.")])]),K,n("p",null,[a("The "),n("a",Q,[X,a(" Http header"),s(e)]),a(" is slightly special. It can contain an "),n("a",Y,[a("HTTP-Date"),s(e)]),a(" or an "),n("a",Z,[a("ETag value"),s(e)]),a(". Therefore, the "),nn,a(" method will return one of the following:")]),n("ul",null,[n("li",null,[n("a",an,[sn,s(e)]),a(" instance")]),en,n("li",null,[tn,a(" ("),n("em",null,[a("if the "),on,a(" header was not set, or if request does not contain a "),cn,a(" header. See "),n("a",pn,[a("RFC-9110"),s(e)]),a(" for additional information")]),a(").")])]),ln,n("p",null,[a("The "),rn,a(" method allows you to set the "),n("a",dn,[un,a(" Http header"),s(e)]),a(", from an "),hn,a(" instance. "),kn,a(": "),n("em",null,[a("This method is an adaptation of Symfony's "),n("a",mn,[fn,s(e)]),a(".")])]),gn,n("p",null,[a("The "),vn,a(" method is an adapted version of Symfony's "),n("a",_n,[bn,s(e)]),a(", that allows an "),wn,a(" instance to be specified, along with the rest of the cache headers.")]),Tn])}const qn=l(d,[["render",En],["__file","macros.html.vue"]]);export{qn as default};
