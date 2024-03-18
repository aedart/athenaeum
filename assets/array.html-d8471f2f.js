import{_ as n,p as s,q as a,a1 as e}from"./framework-efe98465.js";const i={},t=e(`<h1 id="array" tabindex="-1"><a class="header-anchor" href="#array" aria-hidden="true">#</a> Array</h1><p><strong>Driver</strong>: <code>\\Aedart\\Translation\\Exports\\Drivers\\ArrayExporter</code></p><p>Exports registered translations to an array.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$translations</span> <span class="token operator">=</span> <span class="token variable">$manager</span>
    <span class="token operator">-&gt;</span><span class="token function">profile</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;array&#39;</span><span class="token punctuation">)</span>
    <span class="token operator">-&gt;</span><span class="token function">export</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;en&#39;</span><span class="token punctuation">,</span> <span class="token punctuation">[</span> <span class="token string single-quoted-string">&#39;auth&#39;</span><span class="token punctuation">,</span> <span class="token string single-quoted-string">&#39;acme::users&#39;</span> <span class="token punctuation">]</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token function">print_r</span><span class="token punctuation">(</span><span class="token variable">$translations</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>The output format looks similar to the following:</p><div class="language-text line-numbers-mode" data-ext="text"><pre class="language-text"><code>Array
(
    [en] =&gt; Array
        (
            [__JSON__] =&gt; Array
                (
                    [The :attribute must contain one letter.] =&gt; The :attribute must contain one letter.
                )
            [auth] =&gt; Array
                (
                    [failed] =&gt; These credentials do not match our records.
                    [password] =&gt; The provided password is incorrect.
                    [throttle] =&gt; Too many login attempts. Please try again in :seconds seconds.
                )
            [acme::users] =&gt; Array
                (
                    [greetings] =&gt; Comrades are the cannons of the weird halitosis.
                    [messages] =&gt; Array
                        (
                            [a] =&gt; Spacecrafts meet with ellipse!
                            [b] =&gt; Uniqueness is the only samadhi, the only guarantee of solitude.
                            [c] =&gt; Ho-ho-ho! punishment of beauty.
                        )
                )
        )
)
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,6),r=[t];function l(o,c){return s(),a("div",null,r)}const p=n(i,[["render",l],["__file","array.html.vue"]]);export{p as default};
