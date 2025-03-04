import{_ as l,M as p,p as i,q as u,R as n,N as a,U as t,t as s,a1 as o}from"./framework-efe98465.js";const r={},d=n("h1",{id:"math",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#math","aria-hidden":"true"},"#"),s(" Math")],-1),k=n("p",null,"Offers math related utility methods.",-1),m={class:"table-of-contents"},v=o(`<h2 id="randomint" tabindex="-1"><a class="header-anchor" href="#randomint" aria-hidden="true">#</a> <code>randomInt()</code></h2><p>Generates a random number between given minimum and maximum values.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Math</span><span class="token punctuation">;</span>

<span class="token variable">$value</span> <span class="token operator">=</span> <span class="token class-name static-context">Math</span><span class="token operator">::</span><span class="token function">randomInt</span><span class="token punctuation">(</span><span class="token number">1</span><span class="token punctuation">,</span> <span class="token number">10</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="seed" tabindex="-1"><a class="header-anchor" href="#seed" aria-hidden="true">#</a> <code>seed()</code></h2><p>Generates a value that can be used for seeding the random number generator.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Math</span><span class="token punctuation">;</span>

<span class="token variable">$seed</span> <span class="token operator">=</span> <span class="token class-name static-context">Math</span><span class="token operator">::</span><span class="token function">seed</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">mt_srand</span><span class="token punctuation">(</span><span class="token variable">$seed</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="applyseed" tabindex="-1"><a class="header-anchor" href="#applyseed" aria-hidden="true">#</a> <code>applySeed()</code></h2>`,7),h={href:"https://www.php.net/manual/en/function.mt-srand",target:"_blank",rel:"noopener noreferrer"},b=n("code",null,"mt_srand()",-1),g=o(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Math</span><span class="token punctuation">;</span>

<span class="token variable">$seed</span> <span class="token operator">=</span> <span class="token number">123456</span><span class="token punctuation">;</span>
<span class="token variable">$list</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;a&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;b&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;c&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;d&#39;</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Math</span><span class="token operator">::</span><span class="token function">applySeed</span><span class="token punctuation">(</span><span class="token variable">$seed</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$resultA</span> <span class="token operator">=</span> <span class="token variable">$list</span><span class="token punctuation">[</span> <span class="token function">array_rand</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Math</span><span class="token operator">::</span><span class="token function">applySeed</span><span class="token punctuation">(</span><span class="token variable">$seed</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$resultB</span> <span class="token operator">=</span> <span class="token variable">$list</span><span class="token punctuation">[</span> <span class="token function">array_rand</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token keyword">echo</span> <span class="token variable">$resultA</span><span class="token punctuation">;</span> <span class="token comment">// b</span>
<span class="token keyword">echo</span> <span class="token variable">$resultB</span><span class="token punctuation">;</span> <span class="token comment">// b</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="seed-mode" tabindex="-1"><a class="header-anchor" href="#seed-mode" aria-hidden="true">#</a> Seed mode</h3><p>Use the 3rd argument to specify the seeding algorithm mode:</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Utils<span class="token punctuation">\\</span>Math</span><span class="token punctuation">;</span>

<span class="token variable">$seed</span> <span class="token operator">=</span> <span class="token number">123456</span><span class="token punctuation">;</span>
<span class="token variable">$list</span> <span class="token operator">=</span> <span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;a&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;b&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;c&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;d&#39;</span><span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token class-name static-context">Math</span><span class="token operator">::</span><span class="token function">applySeed</span><span class="token punctuation">(</span><span class="token variable">$seed</span><span class="token punctuation">,</span> <span class="token constant">MT_RAND_PHP</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
<span class="token variable">$resultA</span> <span class="token operator">=</span> <span class="token variable">$list</span><span class="token punctuation">[</span> <span class="token function">array_rand</span><span class="token punctuation">(</span><span class="token variable">$list</span><span class="token punctuation">,</span> <span class="token number">1</span><span class="token punctuation">)</span> <span class="token punctuation">]</span><span class="token punctuation">;</span>

<span class="token comment">// ...etc</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,4);function _(f,x){const e=p("router-link"),c=p("ExternalLinkIcon");return i(),u("div",null,[d,k,n("nav",m,[n("ul",null,[n("li",null,[a(e,{to:"#randomint"},{default:t(()=>[s("randomInt()")]),_:1})]),n("li",null,[a(e,{to:"#seed"},{default:t(()=>[s("seed()")]),_:1})]),n("li",null,[a(e,{to:"#applyseed"},{default:t(()=>[s("applySeed()")]),_:1}),n("ul",null,[n("li",null,[a(e,{to:"#seed-mode"},{default:t(()=>[s("Seed mode")]),_:1})])])])])]),v,n("p",null,[s("A wrapper for "),n("a",h,[s("PHP's "),b,a(c)]),s(" method, which seeds the Mersenne Twister Random Number Generator.")]),g])}const y=l(r,[["render",_],["__file","math.html.vue"]]);export{y as default};
