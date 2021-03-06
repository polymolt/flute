# Flute：不留痕迹的”安全”消息传递
WeChat，QQ 等中国大陆流行的通讯软件不仅不支持端到端加密，甚至会需要配合政府审查和监听。在**不得已**需要使用这些软件时，Flute 能够在这些场景中增强敏感信息的安全性。

## 介绍

专为应对非端到端加密、易受审查的通讯软件，Flute 是每个人都能使用的临时通讯安全增强方案。

**1. 加密传递**
在输入消息和密码后，发送者的消息会被基于密码的密钥加密后在服务器上储存。其后，发送者可以向接受者通过通讯软件提供访问链接，并单独发送密钥。

**2. 阅后即焚**
接受者需要访问链接和密钥来访问消息。在解密成功后，消息会在服务器上永久销毁——留在双方聊天记录中的只剩无效的链接和密钥。

请注意，Flute 远无法和安全的端到端通讯软件相比，这只是一个偶尔或临时可用的替代方案——请尽快采用，并传播[更安全的通讯软件](https://blog.yitianshijie.net/2017/03/31/im-apps-security-check-v1point1/)。

### 威胁模型
Flute 主要是为了应对非加密、易受审查通讯软件的两个问题：大规模（随机）监听，以及聊天记录泄漏。

**大规模（随机）监听**
分别发送不带有消息内容的访问链接和解密密钥能避免（随机）监听和关键词探测/审查。

**聊天记录泄漏**
这是更常见的威胁。因为消息在阅读后会立刻销毁，聊天记录因为任何原因泄漏都不会对消息内容产生直接威胁。

### 潜在风险
Flute 是**不得已**需要使用非加密通讯软件与缺乏技术基础的人交换敏感信息的安全增强方案。Flute 无法与端到端通讯软件加密的安全性媲美——这是一个偶尔使用的临时方案。使用 Flute 传递消息有如下显著风险：

**替换消息**
Flute 无法防篡改。除非发送者和接受者同时在线，并在短时间内协调完成消息发送、接受过程，攻击者会有机会通过同样的 Flute 实例生成伪造消息，并通过截获、修改通讯软件中的消息来将发送者的链接和密钥替换为伪造内容的链接和密钥。
(因此用户应该尽可能使用不同渠道分别传递链接和密钥.)

**浏览器安全**
考虑到国内软件发行情况，发送者需要确定自己和接受者正在使用安全的浏览器——避免任何国产浏览器、确保无不可信第三方插件等。

最后，Flute 完 全 无 法 对抗长期（或有计划的）攻击。

### 延伸 Flute
Flute 是一个具有中国特色的软件。在大多数互联网为受审查的国家，所有人的日常通讯交流都可以选择采用易用的端到端加密——例如，常见的 Facebook Messenger 也已支持端到端加密。但在中国，因为语言限制、GFW等原因，不少人无法接触到这类软件。正因如此，Flute 这种能够略微增加通讯安全的工具才会出现。

但同样考虑到互联网审查，Flute 的站点完全可能被墙或关闭。因此如果您有能力保证服务器安全，请部署运行您的私人 Flute 实例，并向您的朋友们分享。不要完全依赖于 Flute 项目站点。

## 通讯流程
Alice 通过 HTTPS 将明文消息和密码传递到服务器后…

Flute 使用 scrypt 加盐获得一个加密密钥和认证密钥。首先，认证密钥会连同明文一起通过 SHA256 HMAC。

完成后，哈希值和明文合并，并使用 AES-256-CTR 加密。加密后，Flute 丢弃明文和密码、两个密钥。储存密文、盐以及IV。

Bob 输入密码，Flute 通过同样的方式再次生成密钥并尝试解密、验证。成功返回明文后，密文和相关信息从服务器销毁。

## TODOs

 (for our community, *you*, also)

**Priority**
- [x] Generate PASS PAD for secured sharing (See Project Wiki).
- [ ] Experts, audit `app/Crypto/Crypto.php` please!!
- [ ] Clean up the code. Make it neat. 
- [ ] Make it Docker-able!

**Future**
- [ ] ~~Adopt Web Crypto API~~

      Considering the browser distribution in domestic China, the browser should not be trusted to perform encryption related works of any kind. Maybe adding a standalone branch of Flute allowing only certain whitelisted browsers can be a workaround. Submit your opinions on *issues*.

- [ ] Support file encryption/sharing.

- [ ] Anonymous Public/Private key message dropping page.

## Thanks To...

@YZKnight

[Laravel](http://laravel.com)

[php-scrypt](https://github.com/DomBlack/php-scrypt)

## 授权协议
 只要你不干蠢事公共协议
   第一版，2017 年 8 月

​         此文本无版权


 拷贝、发行或修改本项目需遵守如下规则：
0. 如果修改、使用本项目密码学相关代码，您必须开源或 PR 至本项目以接受社群审查。
1. 如果本项目涉及网页服务，网页服务必须强制使用 HTTPS 访问。
2. 满足条件 (0.) 和 (1.) 后，你干什么用都无所谓。

