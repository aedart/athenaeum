import{_ as t,M as c,p,q as o,R as n,t as s,N as e,a1 as i}from"./framework-efe98465.js";const l={},r=n("h1",{id:"register-listeners-and-subscribers",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#register-listeners-and-subscribers","aria-hidden":"true"},"#"),s(" Register Listeners and Subscribers")],-1),u={href:"https://laravel.com/docs/10.x/events#registering-events-and-listeners",target:"_blank",rel:"noopener noreferrer"},d={href:"https://laravel.com/docs/10.x/events#event-subscribers",target:"_blank",rel:"noopener noreferrer"},k={href:"https://laravel.com",target:"_blank",rel:"noopener noreferrer"},v=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>
<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token string single-quoted-string">&#39;listeners&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Events<span class="token punctuation">\\</span>UserCreated</span><span class="token operator">::</span><span class="token keyword">class</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Listeners<span class="token punctuation">\\</span>LogNewUser</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Listeners<span class="token punctuation">\\</span>SendWelcomeEmail</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
        <span class="token string single-quoted-string">&#39;payments.*&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acma<span class="token punctuation">\\</span>Payments<span class="token punctuation">\\</span>Listeners<span class="token punctuation">\\</span>VerifyPaymentSession</span><span class="token operator">::</span><span class="token keyword">class</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
        
        <span class="token comment">// ... etc</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>

    <span class="token string single-quoted-string">&#39;subscribers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Orders<span class="token punctuation">\\</span>Subscribers<span class="token punctuation">\\</span>OrderEventsSubscriber</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Subscribers<span class="token punctuation">\\</span>TrialPeriodSubscriber</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>

        <span class="token comment">// ... etc</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function m(b,g){const a=c("ExternalLinkIcon");return p(),o("div",null,[r,n("p",null,[s("The Athenaeum Events package offers way to register "),n("a",u,[s("Event Listeners"),e(a)]),s(" and "),n("a",d,[s("Subscribers"),e(a)]),s(" via configuration.")]),n("p",null,[s("It serves as an alternative registration method than that provided by "),n("a",k,[s("Laravel"),e(a)]),s(".")]),v])}const f=t(l,[["render",m],["__file","index.html.vue"]]);export{f as default};
