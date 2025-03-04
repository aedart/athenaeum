import{_ as l,M as i,p as r,q as u,R as n,N as s,U as e,t as a,a1 as p}from"./framework-efe98465.js";const d={},k=n("h1",{id:"usage",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#usage","aria-hidden":"true"},"#"),a(" Usage")],-1),g=n("p",null,[a("At the heart of this package is a "),n("code",null,"Factory"),a(" that is able to generate "),n("code",null,"ETag"),a(" instances, for arbitrary content, as well as to parse strings that contain etag values and turn them into a collection of etags instances.")],-1),h={class:"table-of-contents"},m=p(`<h2 id="obtain-factory" tabindex="-1"><a class="header-anchor" href="#obtain-factory" aria-hidden="true">#</a> Obtain Factory</h2><p>To obtain the <code>Factory</code> instance, use the <code>ETagGeneratorFactoryTrait</code> in your components.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Traits<span class="token punctuation">\\</span>ETagGeneratorFactoryTrait</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">UsersController</span>
<span class="token punctuation">{</span>
    <span class="token keyword">use</span> <span class="token package">ETagGeneratorFactoryTrait</span><span class="token punctuation">;</span>
    
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">index</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$factory</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getEtagGeneratorFactory</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        
        <span class="token comment">// ..remaining not shown...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="generator" tabindex="-1"><a class="header-anchor" href="#generator" aria-hidden="true">#</a> Generator</h2><p>Before you are able to create a new <code>ETag</code> instance, you must first obtain a <code>Generator</code>. This can be done via the <code>profile()</code> method in the <code>Factory</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$generator</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// Default profile</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><p>To obtain a <code>Generator</code> for a different profile, simply specify the profile&#39;s name as argument.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$generator</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-custom-profile&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div>`,8),v=p('<h2 id="make-an-etag" tabindex="-1"><a class="header-anchor" href="#make-an-etag" aria-hidden="true">#</a> Make an Etag</h2><p>Once you have your desired Etag <code>Generator</code> instance, use the <code>make()</code> method to create a new <code>ETag</code> instance of some content. The method accepts two arguments:</p><ul><li><code>$content</code>: <code>mixed</code> : <em>arbitrary content</em></li><li><code>$weak</code> : <code>bool</code> : <em>optional, default <code>true</code></em></li></ul>',3),f={class:"custom-container tip"},b=p('<p class="custom-container-title">Weak vs. Strong</p><p>If <code>$weak</code> is set to true, the created <code>ETag</code> is flagged as &quot;weak&quot; and therefore indented to be used for &quot;weak comparison&quot; (<em>E.g. <code>If-None-Match</code> Http header comparison</em>).</p><p>Otherwise, when <code>$weak</code> is set to false, the <code>ETag</code> is not flagged as &quot;weak&quot;. Thus, the etag is then intended to be used for &quot;strong comparison&quot; (<em>E.g. <code>If-Match</code> Http header comparison</em>).</p>',3),_={href:"https://httpwg.org/specs/rfc9110.html#entity.tag.comparison",target:"_blank",rel:"noopener noreferrer"},w=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token variable">$generator</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$etag</span><span class="token punctuation">;</span> <span class="token comment">// E.g. W/&quot;ab416j5&quot;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>For the sake of convenience, you can use the shortcut methods <code>makeWeak()</code> and <code>makeStrong()</code> to achieve the same.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$weakEtag</span> <span class="token operator">=</span> <span class="token variable">$generator</span><span class="token operator">-&gt;</span><span class="token function">makeWeak</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$strongEtag</span> <span class="token operator">=</span> <span class="token variable">$generator</span><span class="token operator">-&gt;</span><span class="token function">makeStrong</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$weakEtag</span><span class="token punctuation">;</span> <span class="token comment">// E.g. W/&quot;ab416j5&quot;</span>
<span class="token keyword">echo</span> <span class="token punctuation">(</span><span class="token keyword type-casting">string</span><span class="token punctuation">)</span> <span class="token variable">$strongEtag</span><span class="token punctuation">;</span> <span class="token comment">// E.g. &quot;4720b076892bb2fb65e75af902273c73a2967e4a&quot;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="using-facade" tabindex="-1"><a class="header-anchor" href="#using-facade" aria-hidden="true">#</a> Using Facade</h2>`,4),y={href:"https://laravel.com/docs/9.x/facades",target:"_blank",rel:"noopener noreferrer"},q=p(`<h3 id="create-new-etags" tabindex="-1"><a class="header-anchor" href="#create-new-etags" aria-hidden="true">#</a> Create new Etags</h3><p>To make new etags, simply invoke the <code>make()</code>, <code>makeWeak()</code> or <code>makeStrong()</code> methods on the facade.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>ETags<span class="token punctuation">\\</span>Facades<span class="token punctuation">\\</span>Generator</span><span class="token punctuation">;</span>

<span class="token variable">$weakEtag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeWeak</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$strongEtag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeStrong</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="use-different-profile" tabindex="-1"><a class="header-anchor" href="#use-different-profile" aria-hidden="true">#</a> Use different profile</h3><p>Unless otherwise specified, the &quot;default&quot; generator &quot;profile&quot; is used by the facade, when creating new etag instances. To use a different profile, specify the desired name via the <code>profile()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-custom-profile&#39;</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-content&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="parsing" tabindex="-1"><a class="header-anchor" href="#parsing" aria-hidden="true">#</a> Parsing</h2><p>When you need to create ETag instance from string values, e.g. Http headers, then you can use the <code>parse()</code> method, in the <code>Factory</code>. The method will attempt to parse given etag values and create a collection with corresponding <code>ETag</code> instances.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Via the factory</span>
<span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;15487&quot;, W/&quot;r2d23574&quot;, W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...Or via the Facade</span>
<span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;15487&quot;, W/&quot;r2d23574&quot;, W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>If you only desire to parse a single value, then use the <code>parseSingle()</code> which will return a single <code>ETag</code> instance.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Via the factory</span>
<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token variable">$factory</span><span class="token operator">-&gt;</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;15487&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...Or via the Facade</span>
<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;15487&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><div class="custom-container warning"><p class="custom-container-title">Caution</p><p>Both <code>parse()</code> and <code>parseSingle()</code> will throw an <code>ETagException</code>, if unable to parse given string value.</p><p>For instance, if you try to parse a list of value that contain a wildcard (<code>*</code>), then it is considered syntactically invalid (<em>acc. to RFC9110</em>). An exception will therefore be thrown.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Throws exception ... invalid list of etag values!</span>
<span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;*, W/&quot;r2d23574&quot;, W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;my-invalid-etag-value&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ---------------------------------------------------------------- //</span>

<span class="token comment">// Valid</span>
<span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;*&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// ...Or parse single</span>
<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;*&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token keyword">echo</span> <span class="token variable">$etag</span><span class="token operator">-&gt;</span><span class="token function">isWildcard</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div></div><h2 id="comparison" tabindex="-1"><a class="header-anchor" href="#comparison" aria-hidden="true">#</a> Comparison</h2><p>You have the following two comparison options, when you want to compare etags:</p>`,14),x=n("strong",null,"strong comparison",-1),$=n("strong",null,"weak comparison",-1),E={href:"https://httpwg.org/specs/rfc9110.html#field.if-match",target:"_blank",rel:"noopener noreferrer"},T=n("code",null,"If-Match",-1),W={href:"https://httpwg.org/specs/rfc9110.html#field.if-none-match",target:"_blank",rel:"noopener noreferrer"},F=n("code",null,"If-None-Match",-1),G={href:"https://httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2",target:"_blank",rel:"noopener noreferrer"},C={class:"custom-container tip"},S=n("p",{class:"custom-container-title"},"Strong vs. Weak Comparison",-1),M=n("p",null,[n("em",null,"The herein shown examples do not necessarily represent correct usage of the comparison for http headers."),n("em",null,'To clarify when to use "weak" or "strong" comparison, consider the following:')],-1),I=n("code",null,"If-Match",-1),A=n("strong",null,"strong comparison",-1),V={href:"https://httpwg.org/specs/rfc9110.html#field.if-match",target:"_blank",rel:"noopener noreferrer"},N=n("code",null,"If-None-Match",-1),R=n("strong",null,"weak comparison",-1),U={href:"https://httpwg.org/specs/rfc9110.html#field.if-none-match",target:"_blank",rel:"noopener noreferrer"},B=p(`<h3 id="via-collection" tabindex="-1"><a class="header-anchor" href="#via-collection" aria-hidden="true">#</a> Via Collection</h3><p>When you have a collection of etag instances, you can match a single <code>ETag</code> (<em>or value</em>) against the etags in the collection. The <code>contains()</code> method allows you to do so.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;15487&quot;, W/&quot;r2d23574&quot;, W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token variable">$etag</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeWeak</span><span class="token punctuation">(</span><span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// E.g. W/&quot;c3pio784&quot;</span>

<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false - strong comparison</span>
<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">)</span><span class="token punctuation">;</span>       <span class="token comment">// true - weak comparison</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>You may also compare against a string etag value directly.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false - strong comparison</span>
<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>       <span class="token comment">// true - weak comparison</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="via-etag" tabindex="-1"><a class="header-anchor" href="#via-etag" aria-hidden="true">#</a> Via ETag</h3><p>To compare two <code>ETag</code> instances against each other, use the <code>matches()</code> method.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$etagA</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;r2d23574&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$etagB</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeWeak</span><span class="token punctuation">(</span><span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// E.g. W/&quot;r2d23574&quot;</span>

<span class="token keyword">echo</span> <span class="token variable">$etagA</span><span class="token operator">-&gt;</span><span class="token function">matches</span><span class="token punctuation">(</span><span class="token variable">$etagB</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// false - strong comparison</span>
<span class="token keyword">echo</span> <span class="token variable">$etagA</span><span class="token operator">-&gt;</span><span class="token function">matches</span><span class="token punctuation">(</span><span class="token variable">$etagB</span><span class="token punctuation">)</span><span class="token punctuation">;</span>       <span class="token comment">// true - weak comparison</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="wildcard" tabindex="-1"><a class="header-anchor" href="#wildcard" aria-hidden="true">#</a> Wildcard</h3>`,9),O=n("code",null,"*",-1),H={href:"https://httpwg.org/specs/rfc9110.html#field.if-match",target:"_blank",rel:"noopener noreferrer"},L=n("code",null,"If-Match",-1),P={href:"https://httpwg.org/specs/rfc9110.html#field.if-none-match",target:"_blank",rel:"noopener noreferrer"},j=n("code",null,"If-None-Match",-1),Y=n("code",null,"true",-1),D=n("code",null,"ETag",-1),z=p(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$collection</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parse</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;*&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true - strong comparison</span>
<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;W/&quot;c3pio784&quot;&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>       <span class="token comment">// true - weak comparison</span>

<span class="token comment">// -------------------------------------------------------------------------- //</span>

<span class="token variable">$etagA</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">parseSingle</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;*&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$etagB</span> <span class="token operator">=</span> <span class="token class-name static-context">Generator</span><span class="token operator">::</span><span class="token function">makeWeak</span><span class="token punctuation">(</span><span class="token variable">$content</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// E.g. W/&quot;15487&quot;</span>

<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">,</span> <span class="token constant boolean">true</span><span class="token punctuation">)</span><span class="token punctuation">;</span> <span class="token comment">// true - strong comparison</span>
<span class="token keyword">echo</span> <span class="token variable">$collection</span><span class="token operator">-&gt;</span><span class="token function">contains</span><span class="token punctuation">(</span><span class="token variable">$etag</span><span class="token punctuation">)</span><span class="token punctuation">;</span>       <span class="token comment">// true - weak comparison</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,1);function J(K,Q){const t=i("router-link"),c=i("RouterLink"),o=i("ExternalLinkIcon");return r(),u("div",null,[k,g,n("nav",h,[n("ul",null,[n("li",null,[s(t,{to:"#obtain-factory"},{default:e(()=>[a("Obtain Factory")]),_:1})]),n("li",null,[s(t,{to:"#generator"},{default:e(()=>[a("Generator")]),_:1})]),n("li",null,[s(t,{to:"#make-an-etag"},{default:e(()=>[a("Make an Etag")]),_:1})]),n("li",null,[s(t,{to:"#using-facade"},{default:e(()=>[a("Using Facade")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#create-new-etags"},{default:e(()=>[a("Create new Etags")]),_:1})]),n("li",null,[s(t,{to:"#use-different-profile"},{default:e(()=>[a("Use different profile")]),_:1})])])]),n("li",null,[s(t,{to:"#parsing"},{default:e(()=>[a("Parsing")]),_:1})]),n("li",null,[s(t,{to:"#comparison"},{default:e(()=>[a("Comparison")]),_:1}),n("ul",null,[n("li",null,[s(t,{to:"#via-collection"},{default:e(()=>[a("Via Collection")]),_:1})]),n("li",null,[s(t,{to:"#via-etag"},{default:e(()=>[a("Via ETag")]),_:1})]),n("li",null,[s(t,{to:"#wildcard"},{default:e(()=>[a("Wildcard")]),_:1})])])])])]),m,n("p",null,[a("For more information, see "),s(c,{to:"/archive/v6x/etags/generators/"},{default:e(()=>[a("Generator documentation")]),_:1}),a(".")]),v,n("div",f,[b,n("p",null,[a("For additional information, see "),n("a",_,[a("RFC9110"),s(o)]),a(".")])]),w,n("p",null,[a("This package also comes with a "),n("a",y,[a("Facade"),s(o)]),a(", that allows you to achieve the same as previously shown.")]),q,n("ul",null,[n("li",null,[x,a(": "),n("em",null,[a("two entity tags are equivalent if both are not weak and their opaque-tags match character-by-character (source "),s(c,{to:"/archive/v6x/etags/(https:/httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2)"},{default:e(()=>[a("RFC-9110")]),_:1}),a(").")])]),n("li",null,[$,a(": "),n("em",null,[a('two entity tags are equivalent if their opaque-tags match character-by-character, regardless of either or both being tagged as "weak" (source '),s(c,{to:"/archive/v6x/etags/(https:/httpwg.org/specs/rfc9110.html#rfc.section.8.8.3.2)"},{default:e(()=>[a("RFC-9110")]),_:1}),a(").")])])]),n("p",null,[a("Please read RFC-9110's description of "),n("a",E,[T,s(o)]),a(", "),n("a",W,[F,s(o)]),a(" Http headers, and "),n("a",G,[a("how the comparison works"),s(o)]),a(" to understand the difference and when to use either of the comparison methods.")]),n("div",C,[S,M,n("p",null,[I,a(": "),n("em",null,[a('"[...] An origin server MUST use the '),A,a(' function when comparing entity tags for If-Match [...]" (source '),n("a",V,[a("RFC-9110"),s(o)]),a(")")])]),n("p",null,[N,a(": "),n("em",null,[a('"[...] A recipient MUST use the '),R,a(' function when comparing entity tags for If-None-Match [...]" (source '),n("a",U,[a("RFC-9110"),s(o)]),a(")")])])]),B,n("p",null,[a("A wildcard ("),O,a(") is a valid etag value for both "),n("a",H,[L,s(o)]),a(" and "),n("a",P,[j,s(o)]),a(" Http headers. When comparing against a wildcard, the result will always be "),Y,a(" if you have an "),D,a(' or etag value to compare against, regardless whether you use "weak" or "strong" comparison.')]),z])}const Z=l(d,[["render",J],["__file","usage.html.vue"]]);export{Z as default};
