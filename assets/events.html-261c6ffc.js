import{_ as t,M as o,p as i,q as c,R as n,t as e,N as a,a1 as r}from"./framework-efe98465.js";const p={},l=n("h1",{id:"events",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#events","aria-hidden":"true"},"#"),e(" Events")],-1),d={href:"https://laravel.com/docs/12.x/events",target:"_blank",rel:"noopener noreferrer"},u={href:"https://laravel.com/docs/12.x/events",target:"_blank",rel:"noopener noreferrer"},v=n("h2",{id:"register-event-listeners",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#register-event-listeners","aria-hidden":"true"},"#"),e(" Register Event Listeners")],-1),k={href:"https://laravel.com/docs/12.x/events#defining-listeners",target:"_blank",rel:"noopener noreferrer"},h={href:"https://laravel.com/docs/12.x/events#event-subscribers",target:"_blank",rel:"noopener noreferrer"},m=n("code",null,"/config/events.php",-1),f=n("a",{href:"../../events"},"Athenaeum Package",-1),b=r(`<h3 id="via-service-provider" tabindex="-1"><a class="header-anchor" href="#via-service-provider" aria-hidden="true">#</a> Via Service Provider</h3><p>If the default approach does not work for you, then you can always create a custom Service Provider that registers your desired listeners.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Acme<span class="token punctuation">\\</span>Console<span class="token punctuation">\\</span>Providers</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Events<span class="token punctuation">\\</span>UserHasRegistered</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>Listeners<span class="token punctuation">\\</span>SendWelcomeMessage</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>Helpers<span class="token punctuation">\\</span>Events<span class="token punctuation">\\</span>DispatcherTrait</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Illuminate<span class="token punctuation">\\</span>Support<span class="token punctuation">\\</span>ServiceProvider</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyEventServiceProvider</span> <span class="token keyword">extends</span> <span class="token class-name">ServiceProvider</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">DispatcherTrait</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">boot</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getDispatcher</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">listen</span><span class="token punctuation">(</span>
            <span class="token class-name static-context">UserHasRegistered</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token class-name static-context">SendWelcomeMessage</span><span class="token operator">::</span><span class="token keyword">class</span>
        <span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="limitations" tabindex="-1"><a class="header-anchor" href="#limitations" aria-hidden="true">#</a> Limitations</h2>`,4),_={href:"https://laravel.com/docs/12.x/queues",target:"_blank",rel:"noopener noreferrer"},g={href:"https://laravel.com/docs/12.x/events#queued-event-listeners",target:"_blank",rel:"noopener noreferrer"},y={href:"https://packagist.org/packages/illuminate/queue",target:"_blank",rel:"noopener noreferrer"},x=n("a",{href:"providers"},"Service Providers chapter",-1);function w(S,E){const s=o("ExternalLinkIcon");return i(),c("div",null,[l,n("p",null,[e("The "),n("a",d,[e("Event Dispatcher"),a(s)]),e(" that comes with this package, offers you an application-wide observer pattern implementation. Please read Laravel's "),n("a",u,[e("documentation"),a(s)]),e(", to gain some basic understanding of it's capabilities.")]),v,n("p",null,[e("By default, when you need to register "),n("a",k,[e("event listeners"),a(s)]),e(" or "),n("a",h,[e("subscribers"),a(s)]),e(", you need to state them within your "),m,e(" configuration file. See the "),f,e(" for details and examples.")]),b,n("p",null,[e("This package does not come with Laravel's "),n("a",_,[e("Queues"),a(s)]),e(". As a consequence of this, "),n("a",g,[e("queued event listeners"),a(s)]),e(" are not available by default. You could try to include the "),n("a",y,[e("Queue package"),a(s)]),e(" by yourself. Read the "),x,e(" for additional information.")])])}const L=t(p,[["render",w],["__file","events.html.vue"]]);export{L as default};
