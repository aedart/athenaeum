import{_ as c,M as p,p as i,q as l,R as n,N as a,U as e,t as s,a1 as u}from"./framework-efe98465.js";const r={},d=n("h1",{id:"update-resource",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#update-resource","aria-hidden":"true"},"#"),s(" Update Resource")],-1),k=n("p",null,[n("code",null,"UpdateSingleResourceRequest"),s(" is intended for when an existing resource must be updated.")],-1),v={class:"table-of-contents"},m=u(`<p><strong>Example Request</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Resources<span class="token punctuation">\\</span>UpdateSingleResourceRequest</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Database<span class="token punctuation">\\</span>Eloquent<span class="token punctuation">\\</span>Model</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">App<span class="token punctuation">\\</span>Models<span class="token punctuation">\\</span>User</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">UpdateUser</span> <span class="token keyword">extends</span> <span class="token class-name">UpdateSingleResourceRequest</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">findRecordOrFail</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token class-name return-type">Model</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token class-name static-context">User</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">route</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">mustEvaluatePreconditions</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">bool</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token constant boolean">true</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">rules</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">array</span>
    <span class="token punctuation">{</span>
        <span class="token keyword">return</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;required|string|min:2|max:100&#39;</span>
        <span class="token punctuation">]</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><strong>Example Action</strong></p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token class-name static-context">Route</span><span class="token operator">::</span><span class="token function">patch</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users/{id}&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span> <span class="token punctuation">(</span><span class="token class-name type-declaration">UpdateUser</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token variable">$user</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token property">record</span><span class="token punctuation">;</span>
    <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">validated</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token variable">$user</span><span class="token operator">-&gt;</span><span class="token function">save</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

    <span class="token keyword">return</span> <span class="token class-name static-context">UserResource</span><span class="token operator">::</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$user</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">name</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;users.update&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="authorisation" tabindex="-1"><a class="header-anchor" href="#authorisation" aria-hidden="true">#</a> Authorisation</h2><p>Authorisation checks is performed by the <code>authorizeFoundRecord()</code> method (<em>see source code for details</em>). The request will check against a <code>update</code> ability. From the above shown examples, a <code>users.update</code> ability is checked.</p><h2 id="request-preconditions" tabindex="-1"><a class="header-anchor" href="#request-preconditions" aria-hidden="true">#</a> Request Preconditions</h2>`,7);function b(h,g){const t=p("router-link"),o=p("RouterLink");return i(),l("div",null,[d,k,n("nav",v,[n("ul",null,[n("li",null,[a(t,{to:"#authorisation"},{default:e(()=>[s("Authorisation")]),_:1})]),n("li",null,[a(t,{to:"#request-preconditions"},{default:e(()=>[s("Request Preconditions")]),_:1})])])]),m,n("p",null,[s("See "),a(o,{to:"/archive/v7x/http/api/requests/show-single.html#request-preconditions"},{default:e(()=>[s("Show Request")]),_:1}),s(" for additional information.")])])}const y=c(r,[["render",b],["__file","update-single.html.vue"]]);export{y as default};
