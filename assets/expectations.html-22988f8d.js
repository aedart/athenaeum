import{_ as l,M as o,p as i,q as u,R as s,N as a,U as t,t as n,a1 as c}from"./framework-efe98465.js";const r={},d=s("h1",{id:"response-expectations",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#response-expectations","aria-hidden":"true"},"#"),n(" Response Expectations")],-1),k=s("p",null,[n(`The Http Client offers the possibility to "assert" a response's Http Status Code, headers or payload, should you require it. In this section, the `),s("code",null,"expect()"),n(" method is introduced.")],-1),v={class:"table-of-contents"},h=s("h2",{id:"status-code-expectations",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#status-code-expectations","aria-hidden":"true"},"#"),n(" Status Code Expectations")],-1),m=s("h3",{id:"expect-http-status-code",tabindex:"-1"},[s("a",{class:"header-anchor",href:"#expect-http-status-code","aria-hidden":"true"},"#"),n(" Expect Http Status Code")],-1),b={href:"https://developer.mozilla.org/en-US/docs/Web/HTTP/Status/200",target:"_blank",rel:"noopener noreferrer"},g=s("code",null,"expect()",-1),f=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Teapot<span class="token punctuation">\\</span>StatusCode</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">OK</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>If the received response&#39;s status code does not match, then an <code>ExpectationNotMetException</code> will be thrown.</p><h3 id="otherwise-callback" tabindex="-1"><a class="header-anchor" href="#otherwise-callback" aria-hidden="true">#</a> Otherwise Callback</h3><p>The <code>ExpectationNotMetException</code> is thrown when the expected status code does not match the received status code. However, this is only intended as a &quot;boilerplate&quot; exception. Most likely, you want to throw your own exception. Therefore, when you provide a <code>callable</code> as the second argument, then the <code>ExpectationNotMetException</code> is not thrown. The provided callback is invoked instead.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Teapot<span class="token punctuation">\\</span>StatusCode</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>Status</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>BadResponse</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">OK</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Bad response received: &#39;</span> <span class="token operator">.</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The callback argument is provided with the following arguments, in the given order:</p>`,6),y=s("li",null,[s("code",null,"Status"),n(": A wrapper for the received response's http status code and phrase.")],-1),w=s("code",null,"ResponseInterface",-1),x={href:"https://www.php-fig.org/psr/psr-7/",target:"_blank",rel:"noopener noreferrer"},_=s("code",null,"RequestInterface",-1),S={href:"https://www.php-fig.org/psr/psr-7/",target:"_blank",rel:"noopener noreferrer"},$=c(`<h3 id="range-of-status-codes" tabindex="-1"><a class="header-anchor" href="#range-of-status-codes" aria-hidden="true">#</a> Range of Status Codes</h3><p>The <code>expect()</code> method also accepts a range of status codes. If the received status code matches one of the expected codes, then the response is considered valid. Should it not match, then either the <code>ExpectationNotMetException</code> is thrown, or the callback is invoked (<em>if provided</em>).</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Teapot<span class="token punctuation">\\</span>StatusCode</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>Status</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>BadResponse</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token punctuation">[</span><span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">OK</span><span class="token punctuation">,</span> <span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">NO_CONTENT</span><span class="token punctuation">]</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Bad response received: &#39;</span> <span class="token operator">.</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="advanced-expectations" tabindex="-1"><a class="header-anchor" href="#advanced-expectations" aria-hidden="true">#</a> Advanced Expectations</h2><h3 id="validate-headers-or-payload" tabindex="-1"><a class="header-anchor" href="#validate-headers-or-payload" aria-hidden="true">#</a> Validate Headers or Payload</h3><p>In situations when you need to assert more than the received status code, then you can provide a <code>callable</code> as the first argument. Doing so, will allow you to perform whatever validation logic you may require, upon the received response.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>Status</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Message<span class="token punctuation">\\</span>RequestInterface</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Message<span class="token punctuation">\\</span>ResponseInterface</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>BadResponse</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span>
            <span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">,</span>
            <span class="token class-name type-declaration">ResponseInterface</span> <span class="token variable">$response</span><span class="token punctuation">,</span>
            <span class="token class-name type-declaration">RequestInterface</span> <span class="token variable">$request</span>
        <span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">if</span><span class="token punctuation">(</span> <span class="token operator">!</span> <span class="token variable">$response</span><span class="token operator">-&gt;</span><span class="token function">hasHeader</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;user_id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
                <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Missing user id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
            
            <span class="token comment">// ... other response validation - not shown...</span>

            <span class="token keyword">if</span><span class="token punctuation">(</span> <span class="token operator">!</span> <span class="token variable">$status</span><span class="token operator">-&gt;</span><span class="token function">isSuccessful</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
                <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Bad response received: &#39;</span> <span class="token operator">.</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="multiple-expectations" tabindex="-1"><a class="header-anchor" href="#multiple-expectations" aria-hidden="true">#</a> Multiple Expectations</h3><p>There is no limit to the amount of expectations that you may add for a response. Thus, you can add multiple expectations via the the <code>expect()</code> method. They will be executed in the same order as you add them.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Responses<span class="token punctuation">\\</span>Status</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Message<span class="token punctuation">\\</span>ResponseInterface</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Teapot<span class="token punctuation">\\</span>StatusCode</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Exceptions<span class="token punctuation">\\</span>BadResponse</span><span class="token punctuation">;</span>

<span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token comment">// Expect status code...</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token class-name static-context">StatusCode</span><span class="token operator">::</span><span class="token constant">OK</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Bad response received: &#39;</span> <span class="token operator">.</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$status</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
    
        <span class="token comment">// Expect http header...</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">ResponseInterface</span> <span class="token variable">$response</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">if</span><span class="token punctuation">(</span> <span class="token operator">!</span> <span class="token variable">$response</span><span class="token operator">-&gt;</span><span class="token function">hasHeader</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;user_id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
                <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Missing user id&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>

        <span class="token comment">// Expect payload...</span>
        <span class="token operator">-&gt;</span><span class="token function">expect</span><span class="token punctuation">(</span><span class="token keyword">function</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Status</span> <span class="token variable">$status</span><span class="token punctuation">,</span> <span class="token class-name type-declaration">ResponseInterface</span> <span class="token variable">$response</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token variable">$content</span> <span class="token operator">=</span> <span class="token variable">$response</span><span class="token operator">-&gt;</span><span class="token function">getBody</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">getContents</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token variable">$response</span><span class="token operator">-&gt;</span><span class="token function">getBody</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">rewind</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

            <span class="token variable">$decoded</span> <span class="token operator">=</span> <span class="token function">json_decode</span><span class="token punctuation">(</span><span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token keyword">if</span><span class="token punctuation">(</span><span class="token keyword">empty</span><span class="token punctuation">(</span><span class="token variable">$decoded</span><span class="token punctuation">)</span> <span class="token operator">||</span> <span class="token class-name">json_last_error</span><span class="token punctuation">(</span><span class="token punctuation">)</span> <span class="token operator">!==</span> <span class="token constant">JSON_ERROR_NONE</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
                <span class="token keyword">throw</span> <span class="token keyword">new</span> <span class="token class-name">BadResponse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;Payload is invalid&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
            <span class="token punctuation">}</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h4 id="array-of-callbacks" tabindex="-1"><a class="header-anchor" href="#array-of-callbacks" aria-hidden="true">#</a> Array of Callbacks</h4><p>If you expectations start to get bulky or lengthy, then you <em>should</em> extract them into their own methods. You can add them via an array, using the <code>withExpectations()</code> method. How you choose to extract expectation logic, is entirely up to you.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$response</span> <span class="token operator">=</span> <span class="token variable">$client</span>
        <span class="token operator">-&gt;</span><span class="token function">withExpectations</span><span class="token punctuation">(</span><span class="token punctuation">[</span>
            <span class="token punctuation">[</span><span class="token variable">$this</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;expectOkStatus&#39;</span><span class="token punctuation">]</span><span class="token punctuation">,</span>
            <span class="token variable">$expectUserIdCallback</span><span class="token punctuation">,</span>
            <span class="token comment">// ...etc</span>
        <span class="token punctuation">]</span><span class="token punctuation">)</span>
        <span class="token operator">-&gt;</span><span class="token function">get</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;/users&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="response-manipulation" tabindex="-1"><a class="header-anchor" href="#response-manipulation" aria-hidden="true">#</a> Response Manipulation</h3><p>The <code>expect()</code> method is not design nor intended to manipulate the received response. This falls outside the scope of the given method. It&#39;s only purpose is to allow status code and response validation.</p>`,15);function R(C,E){const e=o("router-link"),p=o("ExternalLinkIcon");return i(),u("div",null,[d,k,s("nav",v,[s("ul",null,[s("li",null,[a(e,{to:"#status-code-expectations"},{default:t(()=>[n("Status Code Expectations")]),_:1}),s("ul",null,[s("li",null,[a(e,{to:"#expect-http-status-code"},{default:t(()=>[n("Expect Http Status Code")]),_:1})]),s("li",null,[a(e,{to:"#otherwise-callback"},{default:t(()=>[n("Otherwise Callback")]),_:1})]),s("li",null,[a(e,{to:"#range-of-status-codes"},{default:t(()=>[n("Range of Status Codes")]),_:1})])])]),s("li",null,[a(e,{to:"#advanced-expectations"},{default:t(()=>[n("Advanced Expectations")]),_:1}),s("ul",null,[s("li",null,[a(e,{to:"#validate-headers-or-payload"},{default:t(()=>[n("Validate Headers or Payload")]),_:1})]),s("li",null,[a(e,{to:"#multiple-expectations"},{default:t(()=>[n("Multiple Expectations")]),_:1})]),s("li",null,[a(e,{to:"#response-manipulation"},{default:t(()=>[n("Response Manipulation")]),_:1})])])])])]),h,m,s("p",null,[n("In order to assert that a received response has a specific Http Status Code, e.g. "),s("a",b,[n("200 OK"),a(p)]),n(", state your expected/desired status code, as the first argument for the "),g,n(" method.")]),f,s("ul",null,[y,s("li",null,[w,n(": The received response ("),s("em",null,[s("a",x,[n("PSR-7"),a(p)])]),n(").")]),s("li",null,[_,n(": The sent request ("),s("em",null,[s("a",S,[n("PSR-7"),a(p)])]),n(").")])]),$])}const T=l(r,[["render",R],["__file","expectations.html.vue"]]);export{T as default};
