import{_ as p,M as o,p as i,q as c,R as n,N as e,U as t,t as s,a1 as l}from"./framework-efe98465.js";const r={},u=n("h1",{id:"custom-grammar",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#custom-grammar","aria-hidden":"true"},"#"),s(" Custom Grammar")],-1),d=n("p",null,"When the default provided Http Query Grammars prove to be insufficient, then you can choose to create a custom grammar.",-1),m={class:"table-of-contents"},k=l(`<h2 id="extend-existing-grammars" tabindex="-1"><a class="header-anchor" href="#extend-existing-grammars" aria-hidden="true">#</a> Extend Existing Grammars</h2><p>If you only require a few tweaks, e.g. when you just wish to alter the &quot;limit&quot; and &quot;offset&quot; keywords, then it&#39;s probably easiest to just extend one of the existing grammars.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Acme<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars<span class="token punctuation">\\</span>DefaultGrammar</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomGrammar</span> <span class="token keyword">extends</span> <span class="token class-name">DefaultGrammar</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">string</span> <span class="token variable">$limitKey</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;take&#39;</span><span class="token punctuation">;</span>

    <span class="token keyword">protected</span> <span class="token keyword type-declaration">string</span> <span class="token variable">$offsetKey</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;skip&#39;</span><span class="token punctuation">;</span>

    <span class="token comment">// ... etc</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>Once you have performed your adaptations, simply create a new grammar profile in your <code>config/http-clients.php</code> and make use of it.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">return</span> <span class="token punctuation">[</span>
    <span class="token comment">// ... previous not shown ...</span>

    <span class="token string single-quoted-string">&#39;grammars&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

        <span class="token string single-quoted-string">&#39;profiles&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

            <span class="token string single-quoted-string">&#39;custom&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>
                <span class="token string single-quoted-string">&#39;driver&#39;</span> <span class="token operator">=&gt;</span> <span class="token class-name class-name-fully-qualified static-context"><span class="token punctuation">\\</span>Acme<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars<span class="token punctuation">\\</span>MyCustomGrammar</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">,</span>
                <span class="token string single-quoted-string">&#39;options&#39;</span> <span class="token operator">=&gt;</span> <span class="token punctuation">[</span>

                    <span class="token comment">// ... remaining not shown ...</span>
                <span class="token punctuation">]</span>
            <span class="token punctuation">]</span><span class="token punctuation">,</span>

            <span class="token comment">// ... remaining not shown ...</span>
        <span class="token punctuation">]</span>
    <span class="token punctuation">]</span>
<span class="token punctuation">]</span><span class="token punctuation">;</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="from-scratch" tabindex="-1"><a class="header-anchor" href="#from-scratch" aria-hidden="true">#</a> From Scratch</h2><p>Alternatively, you can also create an entire grammar by inheriting from the <code>Grammar</code> and <code>Identifiers</code> interfaces. You must then implement a <code>compile()</code> method, which handles all the available methods provided by the Http Query Builder. The following example show how you could get started.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token php language-php"><span class="token delimiter important">&lt;?php</span>

<span class="token keyword">namespace</span> <span class="token package">Acme<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammars</span><span class="token punctuation">;</span>

<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Builder</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Identifiers</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Contracts<span class="token punctuation">\\</span>Http<span class="token punctuation">\\</span>Clients<span class="token punctuation">\\</span>Requests<span class="token punctuation">\\</span>Query<span class="token punctuation">\\</span>Grammar</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyCustomGrammar</span> <span class="token keyword">implements</span> <span class="token class-name">Grammar</span><span class="token punctuation">,</span>
    Identifiers
<span class="token punctuation">{</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">compile</span><span class="token punctuation">(</span><span class="token class-name type-declaration">Builder</span> <span class="token variable">$builder</span><span class="token punctuation">)</span><span class="token punctuation">:</span> <span class="token keyword return-type">string</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$parts</span> <span class="token operator">=</span> <span class="token variable">$builder</span><span class="token operator">-&gt;</span><span class="token function">toArray</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token keyword">if</span> <span class="token punctuation">(</span><span class="token keyword">empty</span><span class="token punctuation">(</span><span class="token variable">$parts</span><span class="token punctuation">)</span><span class="token punctuation">)</span> <span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token string single-quoted-string">&#39;&#39;</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span>

        <span class="token variable">$selects</span> <span class="token operator">=</span> <span class="token variable">$parts</span><span class="token punctuation">[</span><span class="token keyword static-context">self</span><span class="token operator">::</span><span class="token constant">SELECTS</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

        <span class="token comment">// ... remaining not shown...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</span></code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,8);function v(b,g){const a=o("router-link");return i(),c("div",null,[u,d,n("nav",m,[n("ul",null,[n("li",null,[e(a,{to:"#extend-existing-grammars"},{default:t(()=>[s("Extend Existing Grammars")]),_:1})]),n("li",null,[e(a,{to:"#from-scratch"},{default:t(()=>[s("From Scratch")]),_:1})])])]),k])}const y=p(r,[["render",v],["__file","custom_grammar.html.vue"]]);export{y as default};
