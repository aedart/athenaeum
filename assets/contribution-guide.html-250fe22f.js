import{_ as d,M as i,p as u,q as c,R as e,t,N as o,U as n,a1 as s}from"./framework-efe98465.js";const h={},p=e("h1",{id:"contribution-guide",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#contribution-guide","aria-hidden":"true"},"#"),t(" Contribution Guide")],-1),f={href:"https://en.wikipedia.org/wiki/Software_bug",target:"_blank",rel:"noopener noreferrer"},_={class:"table-of-contents"},g=e("h2",{id:"bug-report",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#bug-report","aria-hidden":"true"},"#"),t(" Bug Report")],-1),m={href:"https://github.com/aedart/athenaeum/issues/new/choose",target:"_blank",rel:"noopener noreferrer"},y=s('<ul><li>Where is the defect located</li><li>A good, short and precise description of the defect (<em>Why is it a defect</em>)</li><li>How to replicate the defect</li><li>(<em>A possible solution for how to resolve the defect</em>)</li></ul><p>When time permits it, I will review your issue and take action upon it.</p><h2 id="security-vulnerability" tabindex="-1"><a class="header-anchor" href="#security-vulnerability" aria-hidden="true">#</a> Security Vulnerability</h2>',3),b=e("h2",{id:"feature-request",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#feature-request","aria-hidden":"true"},"#"),t(" Feature Request")],-1),w={href:"https://github.com/aedart/athenaeum/issues/new/choose",target:"_blank",rel:"noopener noreferrer"},k=e("em",null,"or acceptable",-1),v={href:"https://github.com/aedart/athenaeum/discussions",target:"_blank",rel:"noopener noreferrer"},x=e("h2",{id:"code-style",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#code-style","aria-hidden":"true"},"#"),t(" Code Style")],-1),q={href:"https://www.php-fig.org/psr/psr-12/",target:"_blank",rel:"noopener noreferrer"},I=e("h3",{id:"phpdoc",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#phpdoc","aria-hidden":"true"},"#"),t(" PHPDoc")],-1),S={href:"https://www.phpdoc.org/",target:"_blank",rel:"noopener noreferrer"},C=e("h3",{id:"easy-coding-standard",tabindex:"-1"},[e("a",{class:"header-anchor",href:"#easy-coding-standard","aria-hidden":"true"},"#"),t(" Easy Coding Standard")],-1),P={href:"https://github.com/symplify/easy-coding-standard",target:"_blank",rel:"noopener noreferrer"},R={href:"https://www.php-fig.org/psr/psr-12/",target:"_blank",rel:"noopener noreferrer"},B=s(`<div class="language-bash line-numbers-mode" data-ext="sh"><pre class="language-bash"><code><span class="token function">composer</span> run cs
</code></pre><div class="line-numbers" aria-hidden="true"><div class="line-number"></div></div></div><h2 id="fork-code-and-send-pull-request" tabindex="-1"><a class="header-anchor" href="#fork-code-and-send-pull-request" aria-hidden="true">#</a> Fork, code and send pull-request</h2><p>If you wish to fix a bug, add new feature, or perhaps change an existing, then please follow this guideline</p>`,3),E=e("li",null,"Fork this project",-1),H=e("li",null,"Create a new local development branch for the given fix, addition or change",-1),V=e("li",null,"Write your code / changes",-1),j=e("li",null,[t("Create executable test-cases ("),e("em",null,"prove that your changes are solid!"),t(")")],-1),F=e("li",null,"Commit and push your changes to your fork-repository",-1),N=e("li",null,[t("Send a pull-request with your changes ("),e("em",null,'please check "Allow edits from maintainers"'),t(")")],-1),W={href:"https://en.wikipedia.org/wiki/Beer",target:"_blank",rel:"noopener noreferrer"},A=e("p",null,[t("As soon as I receive the pull-request ("),e("em",null,"and have time for it"),t("), I will review your changes and merge them into this project. If not, I will inform you why I choose not to.")],-1);function D(L,G){const r=i("ExternalLinkIcon"),a=i("router-link"),l=i("RouterLink");return u(),c("div",null,[p,e("p",null,[t("Have you found a defect ( "),e("a",f,[t("bug or design flaw"),o(r)]),t(" ), or do you wish improvements? In the following sections, you might find some useful information on how you can help this project. In any case, I thank you for taking the time to help me improve this project's deliverables and overall quality.")]),e("nav",_,[e("ul",null,[e("li",null,[o(a,{to:"#bug-report"},{default:n(()=>[t("Bug Report")]),_:1})]),e("li",null,[o(a,{to:"#security-vulnerability"},{default:n(()=>[t("Security Vulnerability")]),_:1})]),e("li",null,[o(a,{to:"#feature-request"},{default:n(()=>[t("Feature Request")]),_:1})]),e("li",null,[o(a,{to:"#code-style"},{default:n(()=>[t("Code Style")]),_:1}),e("ul",null,[e("li",null,[o(a,{to:"#phpdoc"},{default:n(()=>[t("PHPDoc")]),_:1})]),e("li",null,[o(a,{to:"#easy-coding-standard"},{default:n(()=>[t("Easy Coding Standard")]),_:1})])])]),e("li",null,[o(a,{to:"#fork-code-and-send-pull-request"},{default:n(()=>[t("Fork, code and send pull-request")]),_:1})])])]),g,e("p",null,[t("If you have found a bug, please report it on "),e("a",m,[t("GitHub"),o(r)]),t(". When reporting the bug, do consider the following:")]),y,e("p",null,[t("Please read the "),o(l,{to:"/archive/current/security.html"},{default:n(()=>[t("Security Policy")]),_:1}),t(".")]),b,e("p",null,[t("If you have an idea for a new feature or perhaps changing an existing, feel free to create a "),e("a",w,[t("feature request"),o(r)]),t(". Should you be unsure whether your idea is good ("),k,t("), then perhaps you could start a "),e("a",v,[t("discussion"),o(r)]),t(".")]),x,e("p",null,[t("On a general note, "),e("a",q,[t("PSR-12"),o(r)]),t(" is used as code style guide.")]),I,e("p",null,[e("a",S,[t("PHPDoc"),o(r)]),t(" us used to document source code, such as classes, interfaces, traits, methods...etc. Please make sure that your contributed code is documented accordingly.")]),C,e("p",null,[e("a",P,[t("Easy Coding Standard"),o(r)]),t(" is configured in the project, which is automatically triggered on every push and pull request. It ensures that "),e("a",R,[t("PSR-12"),o(r)]),t(" is upheld. To execute it locally, run the following command:")]),B,e("ul",null,[E,H,V,j,F,N,e("li",null,[e("em",null,[t("Drink a "),e("a",W,[t("Beer"),o(r)]),t(" - you earned it")]),t(" 😃")])]),A])}const M=d(h,[["render",D],["__file","contribution-guide.html.vue"]]);export{M as default};
