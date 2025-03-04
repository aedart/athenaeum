import{_ as c,M as t,p as o,q as l,R as n,t as s,N as a,U as p,a1 as r}from"./framework-efe98465.js";const u={},d=n("h1",{id:"criteria",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#criteria","aria-hidden":"true"},"#"),s(" Criteria")],-1),k=n("em",null,"or criterion",-1),v={href:"https://laravel.com/docs/12.x/eloquent#query-scopes",target:"_blank",rel:"noopener noreferrer"},m={class:"table-of-contents"},h=r(`<h2 id="create-criteria" tabindex="-1"><a class="header-anchor" href="#create-criteria" aria-hidden="true">#</a> Create Criteria</h2><p>To create a criteria, inherit from the <code>Criteria</code> interface and implement the <code>apply()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Acma<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Criteria</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Criteria</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">LowPrice</span> <span class="token keyword">implements</span> <span class="token class-name">Criteria</span>
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">apply</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Builder</span> <span class="token variable">$request</span><span class="token punctuation">)</span> <span class="token punctuation">:</span> <span class="token keyword return-type">void</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$request</span>
            <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;price&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;lt&#39;</span><span class="token punctuation">,</span> <span class="token number">1500</span><span class="token punctuation">)</span>
            <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;currency&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;DKK&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="apply-criteria" tabindex="-1"><a class="header-anchor" href="#apply-criteria" aria-hidden="true">#</a> Apply Criteria</h2><p>Use the <code>applyCriteria()</code> method to add your custom criteria to the request builder.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Acma<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Criteria<span class="token punctuation">\\</span>LowPrice</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">applyCriteria</span><span class="token punctuation">(</span><span class="token keyword">new</span> <span class="token class-name">LowPrice</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/rental-cars&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The method also accepts an array of criteria.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">applyCriteria</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
            <span class="token keyword">new</span> <span class="token class-name">LowPrice</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token keyword">new</span> <span class="token class-name">RentalPeriod</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;+2 week&#39;</span><span class="token punctuation">)</span><span class="token punctuation">,</span>
            <span class="token keyword">new</span> <span class="token class-name">HybridFuel</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/rental-cars&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,8);function b(g,y){const i=t("ExternalLinkIcon"),e=t("router-link");return o(),l("div",null,[d,n("p",null,[s("Within this context, criteria ("),k,s(") is similar to Laravel's database "),n("a",v,[s("Query Scopes"),a(i)]),s(". It allows you to add additional constraints, scopes, attachments, cookies, expectations or http query parameters, whilst isolating it in a separate class.")]),n("nav",m,[n("ul",null,[n("li",null,[a(e,{to:"#create-criteria"},{default:p(()=>[s("Create Criteria")]),_:1})]),n("li",null,[a(e,{to:"#apply-criteria"},{default:p(()=>[s("Apply Criteria")]),_:1})])])]),h])}const f=c(u,[["render",b],["__file","criteria.html.vue"]]);export{f as default};
