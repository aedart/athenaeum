import{_ as r,M as i,p,q as l,R as e,t as n,N as s,U as o,a1 as u}from"./framework-efe98465.js";const c={},d=e("h1",{id:"http-query",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#http-query","aria-hidden":"true"},"#"),n(" Http Query")],-1),h={href:"https://laravel.com/docs/10.x/queries#introduction",target:"_blank",rel:"noopener noreferrer"},m=e("em",null,"but with significantly less features",-1),v=u(`<h2 id="via-uri" tabindex="-1"><a class="header-anchor" href="#via-uri" aria-hidden="true">#</a> Via Uri</h2><p>You can always specify query parameters manually, via the request&#39;s uri.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">withUri</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users?search=John&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">Caution</p><p>If you choose to set query parameters via the uri and also make use the Http Query Builder, then the entire query string provided via the uri is ignored!</p><p>In other words, you <strong>SHOULD NOT</strong> mix the methods of how you state query parameters.</p></div><h2 id="via-configuration" tabindex="-1"><a class="header-anchor" href="#via-configuration" aria-hidden="true">#</a> Via Configuration</h2><p>Another way to specify query parameters, is via your configuration. Here, you may specify a string or an array of key-value pairs.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;default&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
            <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Drivers<span class="token punctuation">\\</span>DefaultHttpClient</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
            <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                
                <span class="token string single-quoted-string">&#39;query&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                    <span class="token string single-quoted-string">&#39;search&#39;</span> <span class="token operator">=&gt;</span> <span class="token string single-quoted-string">&#39;John&#39;</span>
                <span class="token punctuation">]</span>

                <span class="token comment">// ... remaining not shown ...</span>
            <span class="token punctuation">]</span>
        <span class="token punctuation">]</span><span class="token punctuation">,</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The above shown example may not seem very useful, but sometimes you might be working with a type of API, where you always are required to send one or more query parameters, for each request. If that is the case, then you are better off stating these directly into your configuration.</p>`,8),g=e("code",null,"query",-1),k={href:"http://docs.guzzlephp.org/en/stable/request-options.html#query",target:"_blank",rel:"noopener noreferrer"},y=e("div",{class:"custom-container tip"},[e("p",{class:"custom-container-title"},"TIP"),e("p",null,"Query parameters that are added via the configuration are automatically also appended to your Http Query Builder.")],-1);function f(b,q){const a=i("RouterLink"),t=i("ExternalLinkIcon");return p(),l("div",null,[d,e("p",null,[n("The Http Client comes with a powerful "),s(a,{to:"/archive/v7x/http/clients/query/"},{default:o(()=>[n("Http Query Builder")]),_:1}),n(" that allows you to set query parameters in a fluent manner, similar to "),e("a",h,[n("Laravel's database query builder"),s(t)]),n(" ("),m,n("). You can read more about the builder, in the upcoming "),s(a,{to:"/archive/v7x/http/clients/query/"},{default:o(()=>[n("chapter")]),_:1}),n(". For now, the more traditional ways of setting a request's http query parameters is briefly illustrated. This may be useful for you, when the provided query builder isn't able to meet your needs.")]),v,e("p",null,[n("You can read more about the "),g,n(" option, in "),e("a",k,[n("Guzzle's documentation"),s(t)]),n(".")]),y])}const w=r(c,[["render",f],["__file","query.html.vue"]]);export{w as default};
