import{_ as p,M as t,p as r,q as l,R as n,t as e,N as a,U as i,a1 as c}from"./framework-efe98465.js";const d={},u=c(`<h1 id="how-to-use" tabindex="-1"><a class="header-anchor" href="#how-to-use" aria-hidden="true">#</a> How to use</h1><p>Once you have your implementation completed, simply create a new instance of your DTO.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token variable">$person</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">Person</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="property-overloading" tabindex="-1"><a class="header-anchor" href="#property-overloading" aria-hidden="true">#</a> Property overloading</h2><p>If a getter and or setter method has been defined for a property, then it becomes accessible in multiple ways.</p><p>The following example illustrates how the <code>name</code> property can be set and retrieved, in multiple ways.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token comment">// Name can be set using normal setter methods</span>
<span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token function">setName</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;John&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// But you can also just set the property itself</span>
<span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Jack&#39;</span><span class="token punctuation">;</span> <span class="token comment">// Will automatically invoke setName()</span>

<span class="token comment">// And you can also set it using an array-accessor</span>
<span class="token variable">$person</span><span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">]</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;Jane&#39;</span><span class="token punctuation">;</span> <span class="token comment">// Will also automatically invoke setName()</span>

<span class="token comment">// ... //</span>

<span class="token comment">// Obtain name using the regular getter method</span>
<span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token function">getName</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

<span class="token comment">// Can also get it via invoking the property directly</span>
<span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$person</span><span class="token operator">-&gt;</span><span class="token property">name</span><span class="token punctuation">;</span> <span class="token comment">// Will automatically invoke getName()</span>

<span class="token comment">// Lastly, it can also be access via an array-accessor</span>
<span class="token variable">$name</span> <span class="token operator">=</span> <span class="token variable">$person</span><span class="token punctuation">[</span><span class="token string single-quoted-string">&#39;name&#39;</span><span class="token punctuation">]</span><span class="token punctuation">;</span> <span class="token comment">// Also invokes the getName()</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,7),m={href:"https://en.wikipedia.org/wiki/Mutator_method",target:"_blank",rel:"noopener noreferrer"},h={href:"http://php.net/manual/en/language.oop5.overloading.php",target:"_blank",rel:"noopener noreferrer"},v={href:"http://php.net/manual/en/class.arrayaccess.php",target:"_blank",rel:"noopener noreferrer"},k={class:"custom-container tip"},g=n("p",{class:"custom-container-title"},"TIP",-1),b={href:"http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html",target:"_blank",rel:"noopener noreferrer"},_=n("code",null,"@property",-1),y=n("h2",{id:"behind-the-scene",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#behind-the-scene","aria-hidden":"true"},"#"),e(" Behind the Scene")],-1),f=n("code",null,"Overload",-1);function w(x,N){const s=t("ExternalLinkIcon"),o=t("RouterLink");return r(),l("div",null,[u,n("p",null,[e("For additional information, please read about "),n("a",m,[e("Mutators and Accessor"),a(s)]),e(", "),n("a",h,[e("PHP's overloading"),a(s)]),e(", and "),n("a",v,[e("PHP's Array-Access"),a(s)])]),n("div",k,[g,n("p",null,[e("By adding a "),n("a",b,[_,a(s)]),e(" tag to your interface or concrete implementation, your IDE will should be able to auto-complete the overloadable properties.")])]),y,n("p",null,[e("The "),a(o,{to:"/archive/v8x/properties/"},{default:i(()=>[f]),_:1}),e(" component is responsible most of the magic.")])])}const P=p(d,[["render",w],["__file","usage.html.vue"]]);export{P as default};
