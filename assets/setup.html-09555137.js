import{_ as a,M as i,p as t,q as c,R as e,N as r,U as o,t as n,a1 as l}from"./framework-efe98465.js";const d={},p=e("h1",{id:"setup",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#setup","aria-hidden":"true"},"#"),n(" Setup")],-1),u={class:"table-of-contents"},v=l(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>MaintenanceModeServiceProvider</code> inside your <code>config/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Maintenance<span class="token punctuation">\\</span>Modes<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>MaintenanceModeServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,3);function m(k,h){const s=i("router-link");return t(),c("div",null,[p,e("nav",u,[e("ul",null,[e("li",null,[r(s,{to:"#register-service-provider"},{default:o(()=>[n("Register Service Provider")]),_:1})])])]),v])}const _=a(d,[["render",m],["__file","setup.html.vue"]]);export{_ as default};
