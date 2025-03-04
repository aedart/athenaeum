import{_ as r,M as i,p as l,q as d,R as e,t as n,N as s,U as t,a1 as p}from"./framework-efe98465.js";const u={},h=e("h1",{id:"actions",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#actions","aria-hidden":"true"},"#"),n(" Actions")],-1),b=e("code",null,"Actions",-1),m=e("div",{class:"custom-container tip"},[e("p",{class:"custom-container-title"},"Recommendation"),e("p",null,[n("The default provided "),e("code",null,"Actions"),n(" will satisfy the bare minimum requirements of RFC 9110. However, they will most likely not satisfy your every need, for every type of resource that is evaluated. You are therefore "),e("strong",null,"strongly encouraged"),n(" to extend, overwrite or create your own "),e("a",{href:"#custom-actions"},[n("custom "),e("code",null,"Actions")]),n(", when needed.")])],-1),f={class:"table-of-contents"},_=e("h2",{id:"default-actions",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#default-actions","aria-hidden":"true"},"#"),n(" Default Actions")],-1),k=e("p",null,[n("Unless otherwise specified, the "),e("code",null,"DefaultActions"),n(" component is used by the evaluator. In this section, each method of the actions component is briefly described.")],-1),g=e("p",null,[e("em",null,[n("Please see the source code of "),e("code",null,"\\Aedart\\ETags\\Preconditions\\Actions\\DefaultActions"),n(" for additional details.")])],-1),v=e("h3",{id:"abort-state-change-already-succeeded",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#abort-state-change-already-succeeded","aria-hidden":"true"},"#"),n(" Abort State Change Already Succeeded")],-1),w=e("code",null,"abortStateChangeAlreadySucceeded()",-1),y={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status#successful_responses",target:"_blank",rel:"noopener noreferrer"},x=e("code",null,"HttpException",-1),A={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/204",target:"_blank",rel:"noopener noreferrer"},T=e("h3",{id:"abort-precondition-failed",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#abort-precondition-failed","aria-hidden":"true"},"#"),n(" Abort Precondition Failed")],-1),S=e("code",null,"abortPreconditionFailed()",-1),q={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/412",target:"_blank",rel:"noopener noreferrer"},R=e("code",null,"PreconditionFailedHttpException",-1),H=e("em",null,[n("custom "),e("code",null,"HttpException")],-1),P=e("h3",{id:"abort-not-modified",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#abort-not-modified","aria-hidden":"true"},"#"),n(" Abort Not Modified")],-1),C=e("code",null,"abortNotModified()",-1),N={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/304",target:"_blank",rel:"noopener noreferrer"},U=e("code",null,"HttpException",-1),E=e("h3",{id:"abort-bad-request",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#abort-bad-request","aria-hidden":"true"},"#"),n(" Abort Bad Request")],-1),D=e("code",null,"abortBadRequest()",-1),M={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/400",target:"_blank",rel:"noopener noreferrer"},W=e("code",null,"BadRequestHttpException",-1),z=e("code",null,"$reason",-1),B=e("h3",{id:"abort-range-not-satisfiable",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#abort-range-not-satisfiable","aria-hidden":"true"},"#"),n(" Abort Range Not Satisfiable")],-1),$=e("code",null,"abortRangeNotSatisfiable()",-1),F={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/416",target:"_blank",rel:"noopener noreferrer"},I=e("code",null,"RangeNotSatisfiable",-1),L=e("code",null,"Range",-1),O=e("code",null,"$reason",-1),V=e("h3",{id:"process-range",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#process-range","aria-hidden":"true"},"#"),n(" Process Range")],-1),j=e("code",null,"processRange()",-1),Y={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/206",target:"_blank",rel:"noopener noreferrer"},G=e("em",null,"SHOULD NOT",-1),J=p(`<h3 id="ignore-range" tabindex="-1"><a class="header-anchor" href="#ignore-range" aria-hidden="true">#</a> Ignore Range</h3><p><code>ignoreRange()</code> is responsible for changing the state of the provided resource, such that application ignores evt. <code>Range</code> header. The method <em>SHOULD NOT</em> abort the current request, but is allowed to do so if needed.</p><h2 id="custom-actions" tabindex="-1"><a class="header-anchor" href="#custom-actions" aria-hidden="true">#</a> Custom Actions</h2><h3 id="how-to-create" tabindex="-1"><a class="header-anchor" href="#how-to-create" aria-hidden="true">#</a> How to create</h3><p>The easiest way to create your own custom actions, is by extending <code>DefaultActions</code>. Overwrite the desired methods with the logic that you need. Consider the following example:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Preconditions<span class="token punctuation">\\</span>Actions<span class="token punctuation">\\</span>DefaultActions</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomActions</span> <span class="token keyword">extends</span> <span class="token class-name">DefaultActions</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">abortStateChangeAlreadySucceeded</span><span class="token punctuation">(</span>
        <span class="token class-name type-declaration">ResourceContext</span> <span class="token variable">$resource</span>
    <span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">never</span>
    <span class="token punctuation">{</span>    
        <span class="token comment">// Abort request with a custom response (throws HttpException).</span>
        <span class="token function">abort</span><span class="token punctuation">(</span><span class="token function">response</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">json</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;data&#39;</span> <span class="token operator">=&gt;</span> <span class="token variable">$resource</span><span class="token operator">-&gt;</span><span class="token function">data</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token number">200</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">Caution</p><p>When overwriting the &quot;abort&quot; methods, both the preconditions and the evaluator expect those methods to throw an appropriate exception and stop further request processing. If this is not respected, you are very likely to experience undesired behavior.</p></div><h3 id="use-custom-actions" tabindex="-1"><a class="header-anchor" href="#use-custom-actions" aria-hidden="true">#</a> Use custom actions</h3><p>To use custom actions, set the <code>$actions</code> argument in the evaluator&#39;s <code>make()</code> method, or use the <code>setActions()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// When creating a new instance...</span>
<span class="token variable">$evaluator</span> <span class="token operator">=</span> <span class="token class-name static-context">Evaluator</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span>
    <span class="token argument-name">reqeust</span><span class="token punctuation">:</span> <span class="token variable">$request</span><span class="token punctuation">,</span>
    <span class="token argument-name">actions</span><span class="token punctuation">:</span> <span class="token keyword">new</span> <span class="token class-name">MyCustomActions</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
<span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Or, when after instance has been instantiated</span>
<span class="token variable">$evaluator</span><span class="token operator">-&gt;</span><span class="token function">setActions</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">MyCustomActions</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,10);function K(Q,X){const c=i("RouterLink"),a=i("router-link"),o=i("ExternalLinkIcon");return l(),d("div",null,[h,e("p",null,[n("The "),b,n(" component is used to either abort the current request, because a precondition has failed, or to change the state of the requested resource. Usually, such logic is invoked by the "),s(c,{to:"/archive/current/etags/evaluator/preconditions.html"},{default:t(()=>[n("preconditions")]),_:1}),n(".")]),m,e("nav",f,[e("ul",null,[e("li",null,[s(a,{to:"#default-actions"},{default:t(()=>[n("Default Actions")]),_:1}),e("ul",null,[e("li",null,[s(a,{to:"#abort-state-change-already-succeeded"},{default:t(()=>[n("Abort State Change Already Succeeded")]),_:1})]),e("li",null,[s(a,{to:"#abort-precondition-failed"},{default:t(()=>[n("Abort Precondition Failed")]),_:1})]),e("li",null,[s(a,{to:"#abort-not-modified"},{default:t(()=>[n("Abort Not Modified")]),_:1})]),e("li",null,[s(a,{to:"#abort-bad-request"},{default:t(()=>[n("Abort Bad Request")]),_:1})]),e("li",null,[s(a,{to:"#abort-range-not-satisfiable"},{default:t(()=>[n("Abort Range Not Satisfiable")]),_:1})]),e("li",null,[s(a,{to:"#process-range"},{default:t(()=>[n("Process Range")]),_:1})]),e("li",null,[s(a,{to:"#ignore-range"},{default:t(()=>[n("Ignore Range")]),_:1})])])]),e("li",null,[s(a,{to:"#custom-actions"},{default:t(()=>[n("Custom Actions")]),_:1}),e("ul",null,[e("li",null,[s(a,{to:"#how-to-create"},{default:t(()=>[n("How to create")]),_:1})]),e("li",null,[s(a,{to:"#use-custom-actions"},{default:t(()=>[n("Use custom actions")]),_:1})])])])])]),_,k,g,v,e("p",null,[n("The "),w,n(" is responsible for causing the application to return a "),e("a",y,[n("2xx response"),s(o)]),n(" response. The method throws an "),x,n(" with Http status code "),e("a",A,[n("204 No Content"),s(o)]),n(".")]),T,e("p",null,[n("The "),S,n(" is responsible for causing the application to return a "),e("a",q,[n("412 Precondition Failed"),s(o)]),n(" response. The method throws an an "),R,n(" ("),H,n(").")]),P,e("p",null,[n("The "),C,n(" is responsible for causing the application to return a "),e("a",N,[n("304 Not Modified"),s(o)]),n(" response. Method throws an "),U,n(" to achieve this.")]),E,e("p",null,[n("The "),D,n(" is responsible for causing the application to return a "),e("a",M,[n("400 Bad Request"),s(o)]),n(" response. "),W,n(" is thrown with a custom "),z,n(" string, if provided by preconditions.")]),B,e("p",null,[n("The "),$,n(" is responsible for causing the application to return a "),e("a",F,[n("416 Range Not Satisfiable"),s(o)]),n(" response. A "),I,n(" exception is thrown, which also contains information about requested "),L,n(", the total size of the resource, and a possible "),O,n(" why the request was aborted.")]),V,e("p",null,[n("The "),j,n(" method is responsible for changing the state of the provided resource, such that the application is able to respond with a "),e("a",Y,[n("206 Partial Content"),s(o)]),n(" response. This method is given a collection of ranges that were requested. Furthermore, the method "),G,n(" abort the current request, but is allowed to do so if needed.")]),J])}const ee=r(u,[["render",K],["__file","actions.html.vue"]]);export{ee as default};
