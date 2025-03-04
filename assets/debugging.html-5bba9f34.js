import{_ as l,M as i,p,q as d,R as n,N as e,U as t,t as s,a1 as c}from"./framework-efe98465.js";const r={},u=n("h1",{id:"debugging",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#debugging","aria-hidden":"true"},"#"),s(" Debugging")],-1),m=n("p",null,[s("The Http Client offers two methods for debugging outgoing requests and incoming responses; "),n("code",null,"debug()"),s(" and "),n("code",null,"dd()"),s(".")],-1),v={class:"table-of-contents"},k=n("h2",{id:"prerequisite",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#prerequisite","aria-hidden":"true"},"#"),s(" Prerequisite")],-1),g={href:"https://github.com/symfony/var-dumper",target:"_blank",rel:"noopener noreferrer"},b=c(`<div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code><span class="token function">composer</span> require symfony/var-dumper <span class="token parameter variable">--dev</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="debug" tabindex="-1"><a class="header-anchor" href="#debug" aria-hidden="true">#</a> <code>debug()</code></h2><p>The <code>debug()</code> method will dump the outgoing request before it is sent. When the corresponding response has been received, the method will also dump it.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;date&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;today&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">debug</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/weather&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Dumps the following (or similar):</span>
<span class="token comment">//  Array</span>
<span class="token comment">//  (</span>
<span class="token comment">//      [request] =&gt; Array</span>
<span class="token comment">//          (</span>
<span class="token comment">//              [method] =&gt; GET</span>
<span class="token comment">//              [target] =&gt; /weather?date=today</span>
<span class="token comment">//              [uri] =&gt; /weather?date=today</span>
<span class="token comment">//              [protocol_version] =&gt; 1.1</span>
<span class="token comment">//              [headers] =&gt; Array</span>
<span class="token comment">//                  (  </span>
<span class="token comment">//                      [Accept] =&gt; Array</span>
<span class="token comment">//                          (</span>
<span class="token comment">//                              [0] =&gt; application/json</span>
<span class="token comment">//                          )</span>
<span class="token comment">//  </span>
<span class="token comment">//                      [Content-Type] =&gt; Array</span>
<span class="token comment">//                          (</span>
<span class="token comment">//                              [0] =&gt; application/json</span>
<span class="token comment">//                          )</span>
<span class="token comment">//  </span>
<span class="token comment">//                  )</span>
<span class="token comment">//  </span>
<span class="token comment">//              [body] =&gt; []</span>
<span class="token comment">//          )</span>
<span class="token comment">//  </span>
<span class="token comment">//  )</span>

<span class="token comment">// </span>
<span class="token comment">// Example dump of response received </span>
<span class="token comment">//  Array</span>
<span class="token comment">//  (</span>
<span class="token comment">//      [response] =&gt; Array</span>
<span class="token comment">//          (</span>
<span class="token comment">//              [status] =&gt; 404</span>
<span class="token comment">//              [reason] =&gt; Not Found</span>
<span class="token comment">//              [protocol_version] =&gt; 1.1</span>
<span class="token comment">//              [headers] =&gt; Array</span>
<span class="token comment">//                  (</span>
<span class="token comment">//                  )</span>
<span class="token comment">//  </span>
<span class="token comment">//              [body] =&gt; </span>
<span class="token comment">//          )</span>
<span class="token comment">//  </span>
<span class="token comment">//  )</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="dd" tabindex="-1"><a class="header-anchor" href="#dd" aria-hidden="true">#</a> <code>dd()</code></h2><p>Unlike <code>debug()</code>, The <code>dd()</code> method will only dump the outgoing request. Afterwards the method <strong>will exit</strong> the entire script!</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;date&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;today&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">dd</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token comment">// Dumps request and exists the script!</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/weather&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// code never reaches here...</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">WARNING</p><p>It is discouraged to use <code>dd()</code> for anything other than debugging, during development. The method <strong>WILL EXIST YOUR SCRIPT</strong>, which is not favourable within a production environment!</p></div><h2 id="custom-debugging-callback" tabindex="-1"><a class="header-anchor" href="#custom-debugging-callback" aria-hidden="true">#</a> Custom debugging callback</h2><p>If the default provided debugging methods are not to your liking, then you can provide your own custom callback, in which you can perform whatever debugging logic you may wish. Both <code>debug()</code> and <code>dd()</code> accept a callback, which is provided with the following arguments, when invoked.</p>`,10),h=n("li",null,[n("code",null,"string $type"),s(", e.g. "),n("code",null,"'request'"),s(" or "),n("code",null,"'response'"),s(".")],-1),f=n("code",null,"MessageInterface $message",-1),_={href:"https://www.php-fig.org/psr/psr-7/#31-psrhttpmessagemessageinterface",target:"_blank",rel:"noopener noreferrer"},y=n("li",null,[n("code",null,"Builder $builder"),s(", Http request builder instance.")],-1),w=c(`<p>Consider the following example:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Message<span class="token punctuation">\\</span>MessageInterface</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">where</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;date&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;today&#39;</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">debug</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token keyword type-hint">string</span> <span class="token variable">$type</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">MessageInterface</span> <span class="token variable">$message</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">Builder</span> <span class="token variable">$builder</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token variable">$type</span> <span class="token operator">===</span> <span class="token string single-quoted-string">&#39;request&#39;</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
                <span class="token comment">// debug a request...</span>
            <span class="token punctuation">}</span> <span class="token keyword">else</span> <span class="token punctuation">{</span>
                <span class="token comment">// debug response...</span>
            <span class="token punctuation">}</span>       
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/weather&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Dumps request and exists the script!</span>
<span class="token comment">// ...dump not shown here...</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,2);function q(x,$){const a=i("router-link"),o=i("ExternalLinkIcon");return p(),d("div",null,[u,m,n("nav",v,[n("ul",null,[n("li",null,[e(a,{to:"#prerequisite"},{default:t(()=>[s("Prerequisite")]),_:1})]),n("li",null,[e(a,{to:"#debug"},{default:t(()=>[s("debug()")]),_:1})]),n("li",null,[e(a,{to:"#dd"},{default:t(()=>[s("dd()")]),_:1})]),n("li",null,[e(a,{to:"#custom-debugging-callback"},{default:t(()=>[s("Custom debugging callback")]),_:1})])])]),k,n("p",null,[s("To make use of the debugging methods, you must have "),n("a",g,[s("Symfony Var Dump"),e(o)]),s(" available in your project.")]),b,n("ul",null,[h,n("li",null,[f,s(", "),n("a",_,[s("PSR-7 Message"),e(o)]),s(" instance. Either a request or response.")]),y]),w])}const I=l(r,[["render",q],["__file","debugging.html.vue"]]);export{I as default};
