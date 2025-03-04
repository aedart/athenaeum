import{_ as c,M as i,p as r,q as d,R as e,t as n,N as a,U as o,a1 as l}from"./framework-efe98465.js";const p={},h=e("h1",{id:"container",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#container","aria-hidden":"true"},"#"),n(" Container")],-1),u=e("code",null,"\\Aedart\\Container\\IoC",-1),_={href:"https://laravel.com/docs/10.x/container",target:"_blank",rel:"noopener noreferrer"},v={class:"custom-container tip"},m=e("p",{class:"custom-container-title"},"Info",-1),b={href:"https://en.wikipedia.org/wiki/Inversion_of_control",target:"_blank",rel:"noopener noreferrer"},f=e("p",null,"The motivation behind this adaptation is development outside a normal Laravel Application. E.g. testing and development of Laravel dependent packages. In other words, you will most likely not find this useful within your Laravel Application!",-1),g={class:"table-of-contents"},k=l(`<h2 id="how-to-obtain-instance" tabindex="-1"><a class="header-anchor" href="#how-to-obtain-instance" aria-hidden="true">#</a> How to obtain instance</h2><p>To obtain the instance of the IoC Service Container, use the <code>getInstance()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Container<span class="token punctuation">\\</span>IoC</span><span class="token punctuation">;</span>

<span class="token variable">$ioc</span> <span class="token operator">=</span> <span class="token class-name static-context">IoC</span><span class="token operator">::</span><span class="token function">getInstance</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="registerasapplication" tabindex="-1"><a class="header-anchor" href="#registerasapplication" aria-hidden="true">#</a> <code>registerAsApplication()</code></h2><p>Sometimes, when testing your custom Laravel components and services, it can be useful to &quot;trick&quot; them in believing that the <code>Container</code> is the <code>Application</code>. This can be achieved via the <code>registerAsApplication()</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$ioc</span><span class="token operator">-&gt;</span><span class="token function">registerAsApplication</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,6),w=e("code",null,"IoC",-1),x=e("code",null,"app",-1),y=e("em",null,"Laravel Application",-1),I={href:"https://laravel.com/docs/10.x/facades",target:"_blank",rel:"noopener noreferrer"},A=e("code",null,"Facade",-1),C=e("code",null,"IoC",-1),T={class:"custom-container danger"},L=e("p",{class:"custom-container-title"},"Warning",-1),S=e("p",null,[e("strong",null,"DO NOT USE THIS METHOD"),n(" inside your normal Laravel Application. It will highjack the "),e("code",null,"app"),n(" binding, causing all kinds of unexpected and undesirable behaviour. The intended purposes of this method is "),e("strong",null,"for testing only!")],-1),E=e("h4",{id:"why-is-this-available",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#why-is-this-available","aria-hidden":"true"},"#"),n(" Why is this available?")],-1),N={href:"https://laravel.com/docs/10.x/facades",target:"_blank",rel:"noopener noreferrer"},F={href:"https://laravel.com/docs/10.x/providers#the-boot-method",target:"_blank",rel:"noopener noreferrer"},H=e("code",null,"IoC",-1),B={href:"https://github.com/laravel/framework/blob/6.x/src/Illuminate/Contracts/Foundation/Application.php",target:"_blank",rel:"noopener noreferrer"},V=e("code",null,"Application",-1),q=e("strong",null,"considered to be hack!",-1),O=e("p",null,"Be careful how you choose to make use of this, if at all!",-1),W=e("h2",{id:"destroy",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#destroy","aria-hidden":"true"},"#"),n(),e("code",null,"destroy()")],-1),$={href:"https://laravel.com/docs/10.x/facades",target:"_blank",rel:"noopener noreferrer"},D=e("code",null,"Facade",-1),M=e("code",null,"Facade",-1),P=l(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// ...destroy ioc and all of it&#39;s bindings.</span>
<span class="token variable">$ioc</span><span class="token operator">-&gt;</span><span class="token function">destroy</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function U(j,R){const t=i("ExternalLinkIcon"),s=i("router-link");return r(),d("div",null,[h,e("p",null,[n("The "),u,n(" is a slightly adapted version of "),e("a",_,[n("Laravel's Service Container"),a(t)]),n(". Please make sure to read their documentation, before attempting to use this version.")]),e("div",v,[m,e("p",null,[n("IoC stands for "),e("a",b,[n("Inversion of control"),a(t)]),n(".")])]),f,e("nav",g,[e("ul",null,[e("li",null,[a(s,{to:"#how-to-obtain-instance"},{default:o(()=>[n("How to obtain instance")]),_:1})]),e("li",null,[a(s,{to:"#registerasapplication"},{default:o(()=>[n("registerAsApplication()")]),_:1})]),e("li",null,[a(s,{to:"#destroy"},{default:o(()=>[n("destroy()")]),_:1})])])]),k,e("p",null,[n("When invoked, the method will bind the "),w,n(" as the "),x,n(" ("),y,n("). It will also set the "),e("a",I,[A,a(t)]),n("'s application instance to be the "),C,n(". This will allow you to use other facades and ensure that they are able to resolve their bindings, provided your have bound them inside the service container.")]),e("div",T,[L,S,E,e("p",null,[n("Sometimes it's a bit faster to test certain components, without having a full Laravel Application up and running. This can for instance be "),e("a",N,[n("Facades"),a(t)]),n(" or a custom "),e("a",F,[n("Service Provider's boot method"),a(t)]),n(". However, using this method when the "),H,n(" is not a superclass to a Laravel "),e("a",B,[V,a(t)]),n(", is "),q]),O]),W,e("p",null,[n("This method ensures that all bindings are unset, including those located within the "),e("a",$,[D,a(t)]),n(". In addition, when invoked the "),M,n("'s application is also unset.")]),P])}const G=c(p,[["render",U],["__file","service-container.html.vue"]]);export{G as default};
