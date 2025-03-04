import{_ as e,M as t,p as c,q as p,R as n,t as s,N as o,a1 as i}from"./framework-efe98465.js";const l={},r=n("h1",{id:"subscribers",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#subscribers","aria-hidden":"true"},"#"),s(" Subscribers")],-1),u={href:"https://laravel.com/docs/9.x/events#event-subscribers",target:"_blank",rel:"noopener noreferrer"},d=n("code",null,"subscribers",-1),b=n("code",null,"/config/events.php",-1),k=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ...</span>
    <span class="token string single-quoted-string">&#39;subscribers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Imports<span class="token punctuation">\\</span>Subscribers<span class="token punctuation">\\</span>ImportEventSubscriber</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Subscribers<span class="token punctuation">\\</span>UserEventSubscriber</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Api<span class="token punctuation">\\</span>Subscribers<span class="token punctuation">\\</span>ApiEventSubscriber</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token comment">// ... etc</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function m(v,h){const a=t("ExternalLinkIcon");return c(),p("div",null,[r,n("p",null,[s("To register event "),n("a",u,[s("Subscribers"),o(a)]),s(", state the class path of your subscribers inside the "),d,s(" key, in your "),b,s(" file.")]),k])}const f=e(l,[["render",m],["__file","subscribers.html.vue"]]);export{f as default};
