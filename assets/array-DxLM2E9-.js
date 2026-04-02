import{i as e,r as t,s as n,t as r}from"./app-B19bQ_Jx.js";var i=JSON.parse(`{"path":"/archive/v8x/translation/exporters/drivers/array.html","title":"Array","lang":"en-GB","frontmatter":{"description":"About Array Exporter","sidebarDepth":0},"git":{"updatedTime":1740576033000,"contributors":[{"name":"alin","username":"alin","email":"alin@rspsystems.com","commits":4,"url":"https://github.com/alin"}],"changelog":[{"hash":"1ba682e4d81dca7ea2cd25e1c3adb10bdf934959","time":1740576033000,"email":"alin@rspsystems.com","author":"alin","message":"Move \\"current\\" to v8x folder"},{"hash":"6545d234a8b515102f88bb7b147c981e0114b682","time":1710755169000,"email":"alin@rspsystems.com","author":"alin","message":"Add current (v8x) docs"},{"hash":"0b773db2c29e613c193c6a8a8ecaa74e0cc81a52","time":1710755140000,"email":"alin@rspsystems.com","author":"alin","message":"Move v7x docs into own directory"},{"hash":"80c218bc1975f46c640aa9b2b63f19f537cdcecf","time":1677078052000,"email":"alin@rspsystems.com","author":"alin","message":"Add translation package docs"}]},"filePathRelative":"archive/v8x/translation/exporters/drivers/array.md","lastUpdatedDateFormat":"yyyy-MM-dd HH:mm:ss ZZZZ","lastUpdatedDateOptions":{}}`),a={name:`array.md`};function o(r,i,a,o,s,c){return n(),t(`div`,null,[...i[0]||=[e(`<h1 id="array" tabindex="-1"><a class="header-anchor" href="#array"><span>Array</span></a></h1><p><strong>Driver</strong>: <code>\\Aedart\\Translation\\Exports\\Drivers\\ArrayExporter</code></p><p>Exports registered translations to an array.</p><div class="language-php line-numbers-mode" data-highlighter="prismjs" data-ext="php"><pre><code class="language-php"><span class="line"><span class="token variable">$translations</span> <span class="token operator">=</span> <span class="token variable">$manager</span></span>
<span class="line">    <span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span></span>
<span class="line">    <span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;acme::users&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span>
<span class="line"><span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$translations</span><span class="token punctuation">)</span><span class="token punctuation">;</span></span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The output format looks similar to the following:</p><div class="language-text line-numbers-mode" data-highlighter="prismjs" data-ext="text"><pre><code class="language-text"><span class="line">Array</span>
<span class="line">(</span>
<span class="line">    [en] =&gt; Array</span>
<span class="line">        (</span>
<span class="line">            [__JSON__] =&gt; Array</span>
<span class="line">                (</span>
<span class="line">                    [The :attribute must contain one letter.] =&gt; The :attribute must contain one letter.</span>
<span class="line">                )</span>
<span class="line">            [auth] =&gt; Array</span>
<span class="line">                (</span>
<span class="line">                    [failed] =&gt; These credentials do not match our records.</span>
<span class="line">                    [password] =&gt; The provided password is incorrect.</span>
<span class="line">                    [throttle] =&gt; Too many login attempts. Please try again in :seconds seconds.</span>
<span class="line">                )</span>
<span class="line">            [acme::users] =&gt; Array</span>
<span class="line">                (</span>
<span class="line">                    [greetings] =&gt; Comrades are the cannons of the weird halitosis.</span>
<span class="line">                    [messages] =&gt; Array</span>
<span class="line">                        (</span>
<span class="line">                            [a] =&gt; Spacecrafts meet with ellipse!</span>
<span class="line">                            [b] =&gt; Uniqueness is the only samadhi, the only guarantee of solitude.</span>
<span class="line">                            [c] =&gt; Ho-ho-ho! punishment of beauty.</span>
<span class="line">                        )</span>
<span class="line">                )</span>
<span class="line">        )</span>
<span class="line">)</span>
<span class="line"></span></code></pre><div class="line-numbers" aria-hidden="true" style="counter-reset:line-number 0;"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6)]])}var s=r(a,[[`render`,o]]);export{i as _pageData,s as default};