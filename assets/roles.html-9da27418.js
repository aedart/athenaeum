import{_ as r,M as n,p as i,q as l,R as s,t as e,N as a,U as p,a1 as c}from"./framework-efe98465.js";const d={},u=s("h1",{id:"roles",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#roles","aria-hidden":"true"},"#"),e(" Roles")],-1),h=s("em",null,"you can only read the existing roles via the API!",-1),m={href:"https://www.redmine.org/projects/redmine/wiki/Rest_Roles",target:"_blank",rel:"noopener noreferrer"},k=c(`<h2 id="fetch-roles-list" tabindex="-1"><a class="header-anchor" href="#fetch-roles-list" aria-hidden="true">#</a> Fetch roles list</h2><p>WHen you fetch the list of roles, you are only provided with an id and a name for the role. It will NOT contain all details about a given role.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Redmine<span class="token punctuation">\\</span>Role</span><span class="token punctuation">;</span>

<span class="token variable">$roles</span> <span class="token operator">=</span> <span class="token class-name static-context">Role</span><span class="token operator">::</span><span class="token function">list</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> 
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p><strong>Note</strong>: <em>The roles API resource does not support pagination!</em></p><h2 id="fetch-single-role" tabindex="-1"><a class="header-anchor" href="#fetch-single-role" aria-hidden="true">#</a> Fetch single role</h2><p>If you require additional details about a role, e.g. what permissions it grants, then you must obtain the role by it&#39;s id.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$role</span> <span class="token operator">=</span> <span class="token class-name static-context">Role</span><span class="token operator">::</span><span class="token function">findOrFail</span><span class="token punctuation">(</span><span class="token number">6</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$permissions</span> <span class="token operator">=</span> <span class="token variable">$role</span><span class="token operator">-&gt;</span><span class="token property">permissions</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,7);function v(b,g){const t=n("RouterLink"),o=n("ExternalLinkIcon");return i(),l("div",null,[u,s("p",null,[e("When working with "),a(t,{to:"/archive/v5x/redmine/resources/memberships.html"},{default:p(()=>[e("project memberships")]),_:1}),e(", you will be required to state which role(s) users are groups are to be granted, when assigned to a proejct. Unfortunately, Redmine's API does not permit creating these roles; "),h,e(". See "),s("a",m,[e("Redmine's API documentation"),a(o)]),e(" for details.")]),k])}const f=r(d,[["render",v],["__file","roles.html.vue"]]);export{f as default};
