import{_ as l,M as c,p as r,q as d,R as n,t as s,N as a,U as e,a1 as i}from"./framework-efe98465.js";const u={},k=n("h1",{id:"test-cases",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#test-cases","aria-hidden":"true"},"#"),s(" Test Cases")],-1),v=n("code",null,"Unit",-1),m={href:"https://packagist.org/packages/phpunit/phpunit",target:"_blank",rel:"noopener noreferrer"},h={class:"table-of-contents"},b=n("h2",{id:"prerequisite",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#prerequisite","aria-hidden":"true"},"#"),s(" Prerequisite")],-1),g={href:"https://codeception.com/docs/01-Introduction",target:"_blank",rel:"noopener noreferrer"},f=n("h2",{id:"unit-test-case",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#unit-test-case","aria-hidden":"true"},"#"),s(" Unit Test-Case")],-1),y={href:"https://github.com/fzaninotto/Faker",target:"_blank",rel:"noopener noreferrer"},_={href:"https://github.com/mockery/mockery",target:"_blank",rel:"noopener noreferrer"},w=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Testing<span class="token punctuation">\\</span>TestCases<span class="token punctuation">\\</span>UnitTestCase</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">UnitTestCase</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * <span class="token keyword">@test</span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">isFakerAvailable</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$value</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getFaker</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token property">address</span><span class="token punctuation">;</span>

        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">assertNotEmpty</span><span class="token punctuation">(</span><span class="token variable">$value</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="faker-locale" tabindex="-1"><a class="header-anchor" href="#faker-locale" aria-hidden="true">#</a> Faker Locale</h3>`,2),T={href:"https://github.com/fzaninotto/Faker#localization",target:"_blank",rel:"noopener noreferrer"},C=n("code",null,"$FakerLocale",-1),x=i(`<div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">UnitTestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token operator">?</span><span class="token keyword type-hint">string</span> <span class="token variable">$FakerLocale</span> <span class="token operator">=</span> <span class="token string single-quoted-string">&#39;da_DK&#39;</span><span class="token punctuation">;</span>
    
    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>See the source code of <code>Aedart\\Testing\\TestCases\\Partials\\FakerPartial</code> for additional information.</p><h2 id="integration-test-case" tabindex="-1"><a class="header-anchor" href="#integration-test-case" aria-hidden="true">#</a> Integration Test-Case</h2><p>The <code>IntegrationTestCase</code> abstraction is suitable for more complex testing. It automatically creates a <a href="../container">Service Container</a> instance before each test and destroys it again after each test. This allows you to test components that depend on the Service Container.</p><p>This test-case inherits from the <code>UnitTestCase</code> abstraction, meaning that a Faker instance is available and Mockery is also setup.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Testing<span class="token punctuation">\\</span>TestCases<span class="token punctuation">\\</span>IntegrationTestCase</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Users<span class="token punctuation">\\</span>UserModel</span><span class="token punctuation">;</span>
<span class="token keyword">use</span> <span class="token package">Acme<span class="token punctuation">\\</span>Data<span class="token punctuation">\\</span>DataLink</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">IntegrationTestCase</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * <span class="token keyword">@test</span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">canCreateSpecialComponent</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token comment">// E.g. bind instances</span>
        <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">ioc</span><span class="token operator">-&gt;</span><span class="token function">bind</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;data-link&#39;</span><span class="token punctuation">,</span> <span class="token keyword">function</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">{</span>
            <span class="token keyword">return</span> <span class="token keyword">new</span> <span class="token class-name">DataLink</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token punctuation">}</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// E.g. resolve components that depend on other</span>
        <span class="token comment">// components...</span>
        <span class="token variable">$userModel</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">ioc</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token class-name static-context">UserModel</span><span class="token operator">::</span><span class="token keyword">class</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// Or perhaps... </span>
        <span class="token variable">$otherUserModel</span> <span class="token operator">=</span> <span class="token keyword">new</span> <span class="token class-name">UserModel</span><span class="token punctuation">(</span><span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">ioc</span><span class="token punctuation">)</span><span class="token punctuation">;</span>
        <span class="token variable">$otherUserModel</span><span class="token operator">-&gt;</span><span class="token property">name</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token function">getFaker</span><span class="token punctuation">(</span><span class="token punctuation">)</span><span class="token operator">-&gt;</span><span class="token property">name</span><span class="token punctuation">;</span>

        <span class="token comment">// ... remaining not shown ...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h3 id="service-container-as-application" tabindex="-1"><a class="header-anchor" href="#service-container-as-application" aria-hidden="true">#</a> Service Container As Application</h3>`,7),A={class:"custom-container danger"},L=i(`<p class="custom-container-title">Warning</p><p>By default, the created Service Container instance is automatically registered as &quot;application&quot;. This means that it binds itself as the <code>app</code> keyword (<em>Laravel Application</em>). This can be useful for testing your components in combination with Laravel&#39;s Service Providers or other Laravel core components. But this can also result in very unexpected and undesirable behaviour. <strong>Please be very careful how use make use of this!</strong></p><h4 id="how-to-disable" tabindex="-1"><a class="header-anchor" href="#how-to-disable" aria-hidden="true">#</a> How to disable</h4><p>To disable this behaviour, set <code>$registerAsApplication</code> to <code>false</code>.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">IntegrationTestCase</span>
<span class="token punctuation">{</span>
    <span class="token keyword">protected</span> <span class="token keyword type-declaration">bool</span> <span class="token variable">$registerAsApplication</span> <span class="token operator">=</span> <span class="token constant boolean">false</span><span class="token punctuation">;</span>

    <span class="token comment">// ... remaining not shown ...</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div>`,5),$=n("code",null,"registerAsApplication()",-1),I=n("h2",{id:"laravel-test-case",tabindex:"-1"},[n("a",{class:"header-anchor",href:"#laravel-test-case","aria-hidden":"true"},"#"),s(" Laravel Test-Case")],-1),M=n("code",null,"LaravelTestCase",-1),F={href:"https://packagist.org/packages/orchestra/testbench",target:"_blank",rel:"noopener noreferrer"},U=n("code",null,"IntegrationTestCase",-1),q=i(`<div class="custom-container tip"><p class="custom-container-title">Note</p><p>The <code>$registerAsApplication</code> property is set to <code>false</code> in this test-case.</p></div><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Testing<span class="token punctuation">\\</span>TestCases<span class="token punctuation">\\</span>LaravelTestCase</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">LaravelTestCase</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * <span class="token keyword">@test</span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">canAccessLaravelComponents</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$redis</span> <span class="token operator">=</span> <span class="token variable">$this</span><span class="token operator">-&gt;</span><span class="token property">ioc</span><span class="token operator">-&gt;</span><span class="token function">make</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;redis&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// ... remaining not shown ...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><h2 id="athenaeum-test-case" tabindex="-1"><a class="header-anchor" href="#athenaeum-test-case" aria-hidden="true">#</a> Athenaeum Test-Case</h2><p>If you are using the <a href="../core">Athenaeum Core Application</a>, then you can use the <code>AthenaeumTestCase</code> to help you test your components or application. It only offers a few handful of the testing capabilities that the Laravel Test-Case does. However, it might just be enough to get you started.</p><p>The test-case ensures that an application instance is created before each test, and destroyed after each test has completed. Since it also inherits from <code>IntegrationTestCase</code>, it too offers the Faker instance and Mockery setup.</p><div class="language-php line-numbers-mode" data-ext="php"><pre class="language-php"><code><span class="token keyword">use</span> <span class="token package">Aedart<span class="token punctuation">\\</span>Testing<span class="token punctuation">\\</span>TestCases<span class="token punctuation">\\</span>AthenaeumTestCase</span><span class="token punctuation">;</span>

<span class="token keyword">class</span> <span class="token class-name-definition class-name">MyTest</span> <span class="token keyword">extends</span> <span class="token class-name">AthenaeumTestCase</span>
<span class="token punctuation">{</span>
    <span class="token doc-comment comment">/**
     * <span class="token keyword">@test</span>
     */</span>
    <span class="token keyword">public</span> <span class="token keyword">function</span> <span class="token function-definition function">canExecuteCustomCommand</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
    <span class="token punctuation">{</span>
        <span class="token variable">$exitCode</span> <span class="token operator">=</span> <span class="token variable">$this</span>
            <span class="token operator">-&gt;</span><span class="token function">withoutMockingConsoleOutput</span><span class="token punctuation">(</span><span class="token punctuation">)</span>
            <span class="token operator">-&gt;</span><span class="token function">artisan</span><span class="token punctuation">(</span><span class="token string single-quoted-string">&#39;pirate:talk&#39;</span><span class="token punctuation">)</span><span class="token punctuation">;</span>

        <span class="token comment">// ... remaining not shown ...</span>
    <span class="token punctuation">}</span>
<span class="token punctuation">}</span>
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div><div class="line-number"></div></div></div><p>For additional information, please review the source code of the <code>AthenaeumTestCase</code>.</p>`,7);function S(P,E){const o=c("ExternalLinkIcon"),t=c("router-link"),p=c("RouterLink");return r(),d("div",null,[k,n("p",null,[s("The following test-case abstractions are available. All test-cases inherit from Codeception's "),v,s(" test-case ("),n("em",null,[s("extended version of "),n("a",m,[s("PHPUnit Test-Case"),a(o)])]),s(").")]),n("nav",h,[n("ul",null,[n("li",null,[a(t,{to:"#prerequisite"},{default:e(()=>[s("Prerequisite")]),_:1})]),n("li",null,[a(t,{to:"#unit-test-case"},{default:e(()=>[s("Unit Test-Case")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#faker-locale"},{default:e(()=>[s("Faker Locale")]),_:1})])])]),n("li",null,[a(t,{to:"#integration-test-case"},{default:e(()=>[s("Integration Test-Case")]),_:1}),n("ul",null,[n("li",null,[a(t,{to:"#service-container-as-application"},{default:e(()=>[s("Service Container As Application")]),_:1})])])]),n("li",null,[a(t,{to:"#laravel-test-case"},{default:e(()=>[s("Laravel Test-Case")]),_:1})]),n("li",null,[a(t,{to:"#athenaeum-test-case"},{default:e(()=>[s("Athenaeum Test-Case")]),_:1})])])]),b,n("p",null,[s("It is recommended that you have some experience working with Codeception. Please read their "),n("a",g,[s("documentation"),a(o)]),s(" before continuing here.")]),f,n("p",null,[s("A basic unit test-case that has a "),n("a",y,[s("Faker"),a(o)]),s(" instance setup. Furthermore, "),n("a",_,[s("Mockery"),a(o)]),s(" is automatically closed after each test. This abstraction is mostly suited for testing single components in isolation.")]),w,n("p",null,[s("To change the "),n("a",T,[s("locale"),a(o)]),s(" that the Faker instance should use, set the "),C,s(" property.")]),x,n("div",A,[L,n("p",null,[s("See "),a(p,{to:"/archive/v4x/container/reg-as-app.html"},{default:e(()=>[$]),_:1}),s(" for additional information.")])]),I,n("p",null,[s("The "),M,s(" starts a new Laravel application before each test and destroys it again, after each test has completed. It utilises "),n("a",F,[s("Orchestra Testbench"),a(o)]),s(" to achieve this. It inherits from the "),U,s(" and therefore also offers the same features and previously shown.")]),q])}const B=l(u,[["render",S],["__file","test-cases.html.vue"]]);export{B as default};
