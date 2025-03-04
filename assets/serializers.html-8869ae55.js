import{_ as l,M as i,p as r,q as p,R as n,t as s,N as a,U as o,a1 as c}from"./framework-efe98465.js";const d={},u=n("h1",{id:"serializers",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#serializers","aria-hidden":"true"},"#"),s(" Serializers")],-1),v=n("code",null,"Factory",-1),m={href:"https://www.php-fig.org/psr/psr-7/#31-psrhttpmessagemessageinterface",target:"_blank",rel:"noopener noreferrer"},k=n("code",null,"MessageInterface",-1),h=n("code",null,"Serializer",-1),b=n("code",null,"string",-1),g=n("code",null,"array",-1),_={class:"table-of-contents"},f={href:"https://github.com/laminas/laminas-diactoros",target:"_blank",rel:"noopener noreferrer"},q={href:"https://docs.laminas.dev/laminas-diactoros/v2/serialization/",target:"_blank",rel:"noopener noreferrer"},y=c(`<h2 id="register-service-provider" tabindex="-1"><a class="header-anchor" href="#register-service-provider" aria-hidden="true">#</a> Register Service Provider</h2><p>Register <code>HttpSerializationServiceProvider</code> in your <code>configs/app.php</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">return</span> <span class="token punctuation">[</span>

    <span class="token comment">// ... previous not shown ... //</span>

    <span class="token comment">/*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    */</span>

    <span class="token string single-quoted-string">&#39;providers&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Messages<span class="token punctuation">\\</span>Providers<span class="token punctuation">\\</span>HttpSerializationServiceProvider</span><span class="token operator">::</span><span class="token keyword">class</span>

        <span class="token comment">// ... remaining services not shown ... //</span>
    <span class="token punctuation">]</span><span class="token punctuation">,</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="obtain-serializer" tabindex="-1"><a class="header-anchor" href="#obtain-serializer" aria-hidden="true">#</a> Obtain Serializer</h2><p>Use the <code>HttpSerializerFactoryTrait</code> component to obtain the serializer <code>Factory</code>. The factory offers a <code>make()</code> method, which accepts a <code>MessageInterface</code> instance.</p>`,5),z={class:"custom-container tip"},S=n("p",{class:"custom-container-title"},"TIP",-1),w=n("code",null,"RequestInterface",-1),x=n("code",null,"ServerRequestInterface",-1),T=n("code",null,"ResponseInterface",-1),H=n("code",null,"MessageInterface",-1),R={href:"https://www.php-fig.org/psr/psr-7/",target:"_blank",rel:"noopener noreferrer"},P=c(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Messages<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>HttpSerializerFactoryTrait</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Psr<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Message<span class="token punctuation">\\</span>ResponseInterface</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">WeatherServiceHandler</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">HttpSerializerFactoryTrait</span><span class="token punctuation">;</span>

    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">handle</span><span class="token punctuation">(</span><span class="token class-name type-declaration">ResponseInterface</span> <span class="token variable">$response</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$serializer</span> <span class="token operator">=</span> <span class="token variable">$this</span>
                        <span class="token operator">-&gt;</span><span class="token function">getHttpSerializerFactory</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
                        <span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$response</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// ... remaining not shown ...    </span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="tostring" tabindex="-1"><a class="header-anchor" href="#tostring" aria-hidden="true">#</a> <code>toString()</code></h2><p>Use the <code>toString()</code> to get a <code>string</code> representation of the Http message. You may also cast the serializer to achieve same result.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$serializer</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">echo</span> <span class="token variable">$serializer</span><span class="token operator">-&gt;</span><span class="token function">toString</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Example Output</span>
<span class="token comment">//</span>
<span class="token comment">// GET /users?created_at=2020 HTTP/1.1</span>
<span class="token comment">// Host: acme.org</span>
<span class="token comment">// Content-Type: application/json</span>
<span class="token comment">//  </span>
<span class="token comment">// {&quot;users&quot;:[&quot;Jim&quot;,&quot;Ulla&quot;,&quot;Brian&quot;]}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="toarray" tabindex="-1"><a class="header-anchor" href="#toarray" aria-hidden="true">#</a> <code>toArray()</code></h2><p>To get an <code>array</code> representation of the Http message, use the <code>toArray()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$serializer</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token variable">$request</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token function">dd</span><span class="token punctuation">(</span><span class="token variable">$serializer</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Example Output</span>
<span class="token comment">//</span>
<span class="token comment">// array:6 [</span>
<span class="token comment">//  &quot;method&quot; =&gt; &quot;GET&quot;</span>
<span class="token comment">//  &quot;target&quot; =&gt; &quot;/users?created_at=2020&quot;</span>
<span class="token comment">//  &quot;uri&quot; =&gt; &quot;https://acme.org/users?created_at=2020&quot;</span>
<span class="token comment">//  &quot;protocol_version&quot; =&gt; &quot;1.1&quot;</span>
<span class="token comment">//  &quot;headers&quot; =&gt; array:2 [</span>
<span class="token comment">//    &quot;Host&quot; =&gt; array:1 [</span>
<span class="token comment">//      0 =&gt; &quot;acme.org&quot;</span>
<span class="token comment">//    ]</span>
<span class="token comment">//    &quot;Content-Type&quot; =&gt; array:1 [</span>
<span class="token comment">//      0 =&gt; &quot;application/json&quot;</span>
<span class="token comment">//    ]</span>
<span class="token comment">//  ]</span>
<span class="token comment">//  &quot;body&quot; =&gt; &quot;{&quot;users&quot;:[&quot;Jim&quot;,&quot;Ulla&quot;,&quot;Brian&quot;]}&quot;</span>
<span class="token punctuation">]</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,7);function $(I,A){const e=i("ExternalLinkIcon"),t=i("router-link");return r(),p("div",null,[u,n("p",null,[s("The Http messages serializer "),v,s(" is able to accept a "),n("a",m,[s("PSR-7 "),k,a(e)]),s(" and return a "),h,s(" instance, which is capable of serializing the provided message into a "),b,s(" or "),g,s(". This can come very handy, e.g. when dealing with Request & Response logging.")]),n("nav",_,[n("ul",null,[n("li",null,[a(t,{to:"#register-service-provider"},{default:o(()=>[s("Register Service Provider")]),_:1})]),n("li",null,[a(t,{to:"#obtain-serializer"},{default:o(()=>[s("Obtain Serializer")]),_:1})]),n("li",null,[a(t,{to:"#tostring"},{default:o(()=>[s("toString()")]),_:1})]),n("li",null,[a(t,{to:"#toarray"},{default:o(()=>[s("toArray()")]),_:1})])])]),n("p",null,[s("The serializers found in this package, are inspired by those available in "),n("a",f,[s("Laminas Diactoros"),a(e)]),s(". Please check their "),n("a",q,[s("documentation"),a(e)]),s(" for additional details.")]),y,n("div",z,[S,n("p",null,[s("PSR-7 "),w,s(", "),x,s(" and "),T,s(" all inherit from the "),H,s(". See "),n("a",R,[s("documentation"),a(e)]),s(" for additional information.")])]),P])}const M=l(d,[["render",$],["__file","serializers.html.vue"]]);export{M as default};
