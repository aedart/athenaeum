import{_ as t,M as o,p as i,q as p,R as n,t as s,N as a,a1 as c}from"./framework-efe98465.js";const r={},l=n("h1",{id:"redmine-api-client",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#redmine-api-client","aria-hidden":"true"},"#"),s(" Redmine Api Client")],-1),d={href:"https://www.redmine.org/",target:"_blank",rel:"noopener noreferrer"},u={href:"https://en.wikipedia.org/wiki/Active_record_pattern",target:"_blank",rel:"noopener noreferrer"},k=c(`<p><strong>Example</strong>:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>Issue</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>Project</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>IssueCategory</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>

<span class="token comment">// Create resources</span>
<span class="token variable">$project</span> <span class="token operator">=</span> <span class="token class-name static-context">Project</span><span class="token operator">::</span><span class="token function">create</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Deus Ex&#39;</span><span class="token punctuation">,</span>
    <span class="token string single-quoted-string">&#39;identifier&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;deus-ex&#39;</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Fetch list of resources, apply filters to http request...</span>
<span class="token variable">$issues</span> <span class="token operator">=</span> <span class="token class-name static-context">Issue</span><span class="token operator">::</span><span class="token function">fetchMultiple</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Builder</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
    <span class="token keyword">return</span> <span class="token variable">$request</span><span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;assigned_to_id&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;me&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Change existing resources</span>
<span class="token variable">$category</span> <span class="token operator">=</span> <span class="token class-name static-context">IssueCategory</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token number">1344</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$category</span><span class="token operator">-&gt;</span><span class="token function">update</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
    <span class="token string single-quoted-string">&#39;name&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;Business Goals&#39;</span>
<span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...or remove them</span>
<span class="token class-name static-context">Issue</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token number">9874</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">delete</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="compatibility" tabindex="-1"><a class="header-anchor" href="#compatibility" aria-hidden="true">#</a> Compatibility</h2><table><thead><tr><th>Athenaeum Redmine Client</th><th>Redmine version</th></tr></thead><tbody><tr><td>From <code>v8.22</code></td><td><code>v4.x</code>, <code>v5.0.x</code>, <code>v5.1.x</code></td></tr><tr><td><code>v7.x</code></td><td><code>v4.x</code></td></tr><tr><td><code>v6.x</code></td><td><code>v4.x</code></td></tr><tr><td>From <code>v5.19</code></td><td><code>v4.x</code></td></tr></tbody></table><p>*:<em>This package might also work with newer versions of Redmine.</em></p><h2 id="limitations" tabindex="-1"><a class="header-anchor" href="#limitations" aria-hidden="true">#</a> Limitations</h2>`,6),m={href:"https://www.redmine.org/projects/redmine/wiki/rest_api",target:"_blank",rel:"noopener noreferrer"},h=n("div",{class:"language-php line-numbers-mode","data-ext":"php"},[n("pre",{class:"language-php"},[n("code",null,`\\Aedart\\Contracts\\Redmine\\Exceptions\\UnsupportedOperationException
`)]),n("div",{class:"line-numbers","aria-hidden":"true"},[n("div",{class:"line-number"})])],-1),v={href:"https://www.redmine.org/projects/redmine/wiki/rest_api",target:"_blank",rel:"noopener noreferrer"},g=n("h2",{id:"alternative",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#alternative","aria-hidden":"true"},"#"),s(" Alternative")],-1),b=n("p",null,"You might also be interested in alternative Redmine API Clients:",-1),_={href:"https://packagist.org/packages/tuner88/laravel-redmine-api",target:"_blank",rel:"noopener noreferrer"},f=n("code",null,"kbsali/redmine-api",-1),w={href:"https://packagist.org/packages/limetecbiotechnologies/redmineapibundle",target:"_blank",rel:"noopener noreferrer"},x=n("code",null,"kbsali/redmine-api",-1),y={href:"https://packagist.org/packages/kbsali/redmine-api",target:"_blank",rel:"noopener noreferrer"};function A(R,q){const e=o("ExternalLinkIcon");return i(),p("div",null,[l,n("p",null,[s("A Laravel "),n("a",d,[s("Redmine"),a(e)]),s(" API Client, that has been designed to look and feel like an "),n("a",u,[s("active record"),a(e)]),s(".")]),k,n("p",null,[s(`This package offers "Resources" that cover most of Redmine's `),n("a",m,[s("REST Api"),a(e)]),s(". Yet, if you have previously worked with Redmine's API, then you know that it can be somewhat inconsistent. Depending on the resource that you are working with, you might not be able to perform certain operations, because it's not supported by the API. You might therefore experience the following exception:")]),h,n("p",null,[s("Please consult yourself with "),n("a",v,[s("Redmine's Api documentation"),a(e)]),s(", to review what operations the current API version supports.")]),g,b,n("ul",null,[n("li",null,[n("a",_,[s("tuner88/laravel-redmine-api"),a(e)]),s(", Laravel wrapper for "),f]),n("li",null,[n("a",w,[s("limetecbiotechnologies/redmineapibundle "),a(e)]),s(", Symfony wrapper for "),x]),n("li",null,[n("a",y,[s("kbsali/redmine-api"),a(e)])])])])}const I=t(r,[["render",A],["__file","index.html.vue"]]);export{I as default};
