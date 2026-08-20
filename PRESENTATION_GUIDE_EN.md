# Lami-a Presentation Guide

**Live demonstration included — approximately 16 to 18 minutes**

## Presentation Goal

The main message of this presentation is:

> Lami-a is an Instagram-style application for food that lets users record and share meals while connecting with people who have similar food preferences.

## Preparation Before the Presentation

- Prepare two regular user accounts and one administrator account.
- Make sure User A is already following User B.
- Prepare two or three food photos for the live post demonstration.
- Add a few categories, locations, posts, comments, and direct messages in advance.
- Open the regular user screen and the administrator screen in separate browser tabs.
- Prepare the description and rating values for the new post beforehand.
- Allow for possible loading and typing delays during the demonstration.

---
まなつ
## 0:00–1:00 — Introduction and the Origin of the Name

### What to Say　

Hello everyone. Today, we would like to introduce **Lami-a**, a food-focused social networking application that we developed.

The name Lami-a was inspired by the original concept of our project: an application connected to our study-abroad experience in Cebu and focused on food.

In simple terms, Lami-a is like **Instagram, but specifically for food**.

Users can record meals, share food photos and reviews, communicate with other users, and discover people who have similar food preferences.

In this presentation, I will explain the concept, target users, main features, points that make the application different, development challenges, and future improvements. I will also demonstrate how the application is used.

### 画面

- ログイン後のホーム画面を表示しておく。

---
まなつ
## 1:00–2:10 — Application Overview

### What to Say

The basic purpose of Lami-a is to help people **record and share their dining experiences**.

On many general social media platforms, people can post food photos and short comments. However, it is often difficult to understand what the reviewer valued or what kind of food that person normally likes.

Lami-a adds more context to food posts. Users can clearly rate different parts of the experience, express their own preferences on their profiles, and connect with other people whose tastes are similar.

This means the application is not only a place to save food memories. It is also a place to discover more relevant recommendations through other users.

---
ゆきさん
## 2:10–3:00 — Target Users

### What to Say

Our main target audience is **women, especially single working women**.

We imagined users who have busy working lives but still enjoy trying restaurants, sharing attractive food photos, and finding new places through recommendations from other people.

For this audience, the application needs to be easy to use, visually enjoyable, and helpful when comparing different meals or restaurants.

This target audience also influenced the application's design. I will explain that design decision later in the presentation.

---
ゆきさん
## 3:50–4:50 — Demonstration 1: Home Page and Following Users

### 操作

1. ホーム画面を見せる。
2. 投稿一覧と右側のおすすめユーザーを指す。
3. おすすめユーザーのプロフィールを開く。
4. フォローボタンを操作する。

### What to Say

The home page displays the current user's posts and posts from the people they follow. The posts are ordered from newest to oldest.

This gives each user a personal timeline based on the people they are interested in.

On the right side, the application suggests users who are not currently being followed. Users can also search for another user by name using the search field at the top.

On a profile, we can see the user's number of posts, followers, and followed accounts. We can follow the user or start a direct conversation from this page.

---
らんさん
## 4:50–7:00 — Demonstration 2: Creating a Food Post

### 操作

1. ナビゲーションバーのプラスボタンを押す。
2. 料理写真を2〜3枚選択し、プレビューを見せる。
3. 料理のカテゴリーを選択する。
4. 場所を検索するか、新しい場所を入力する。
5. 説明文を入力する。
6. Taste、Volume、Value、Vibesを0.5刻みで入力する。
7. 投稿し、ホーム画面または投稿詳細画面で結果を見せる。

### What to Say

Users can upload up to five images in one post and preview them before submission. Multiple images can be viewed in a carousel.

Users can select a food category and add location information. They can choose an existing location or enter a new one. Locations can also be added, edited, and deleted from the administrator screen.

One of Lami-a's main features is its clear four-part rating system.

**Taste** represents the flavor. **Volume** represents the portion size. **Value** represents cost performance, and **Vibes** represents how visually appealing or Instagram-worthy the food and experience are.

Each item is rated out of five in 0.5-point increments. Users can understand the strengths of a meal at a glance instead of relying on one unclear overall score.

When an image is uploaded, the application reduces its longest side to a maximum of 1,600 pixels and compresses it as a JPEG at 80 percent quality. This reduces storage usage and loading time while keeping the image clear enough for viewing.

---
ゆきさん
## 7:00–8:30 — Demonstration 3: Likes, Comments, Replies, and Page Position

### 操作

1. 投稿にいいねを付け、件数が更新されるところを見せる。
2. 操作後も同じ投稿位置に留まることを見せる。
3. コメントを追加する。
4. 既存コメントへの返信を見せる。
5. コメントまたは返信にいいねを付ける。

### What to Say

Users can like and comment on posts. They can also reply to comments and like individual comments or replies.

We also improved the page behavior after these actions. When a user likes a post or comment, JavaScript updates the heart icon and count asynchronously, so the entire page does not reload.

We treated this as a type of **page-position lock**. The user stays focused on the same post instead of being returned to the top of the timeline after an interaction.

This was an important usability improvement because a food timeline can contain many long posts and images. Users should not have to search for the same post again after every like or comment.

---
まなつ
## 8:30–9:50 — Demonstration 4: Taste Profile

### 操作

1. 自分のプロフィールを開く。
2. Taste Profileを見せる。
3. Edit Profileを開き、好みの入力欄を見せる。
4. Posts、Liked Posts、Commented Postsの各セクションを切り替える。

### What to Say

We added a Taste Profile so that users can express their food preferences directly on their profiles.

Users can rate their preference for spicy food, sweet food, meat, and vegetables on a five-level scale. They can also add favorite foods, which appear like tags.

This gives important context to a review. For example, if someone gives a spicy dish a high score, we can check whether that person normally enjoys spicy food.

It also supports our long-term goal of connecting users whose food preferences are similar.

The profile allows users to review their own posts, the posts they liked, and the posts they commented on.

---
まなつ
## 9:50–11:00 — Demonstration 5: Direct Messages

### 操作

1. メッセージ一覧を開く。
2. フォロー中のユーザーとの会話を開く。
3. メッセージを1件送信する。
4. 未読件数、Seen表示、送信者によるメッセージ削除のいずれかを見せる。

### What to Say

We added direct messages so that users can communicate with food creators or other users they are interested in.

Messages are limited to users they currently follow. This reduces unwanted contact and gives users more control over their communication.

The application verifies that the logged-in user is a participant before allowing access to a conversation. It also includes unread message counts, a Seen status, and message deletion by the sender.

---
らんさん
## 11:00–12:10 — Demonstration 6: Administrator Features

### 操作

1. 管理者画面のタブへ切り替える。
2. Users、Posts、Categories、Locationsの各メニューを見せる。
3. Locationsで追加・編集・削除の操作を見せる。
4. ユーザーの停止または投稿の非表示と、Restoreボタンを見せる。

### What to Say

The administrator screen manages users, posts, categories, and locations.

Location management was added together with the location feature for posts. Administrators can add, edit, and delete location data and see how many posts use each location.

Regular users cannot access the administrator area because it has a role-based permission check.

User deactivation and post hiding use soft deletion. Instead of immediately deleting the data permanently, an administrator can restore it later if necessary.

---
まなつ
## 12:10–13:50 — Features We Added and Design Decisions

### What to Say

The first major feature we added was the **Taste Profile**, which allows each user to express their personal preferences.

The second was the structured post rating system. Taste, volume, cost performance, and visual appeal can be understood at a glance.

We also added location information and made it editable from the administrator screen.

For media, we expanded the original single-image post feature so that users can upload multiple images. We also added image resizing and compression to control file size and loading performance.

For communication, we added direct messages, comment replies, and likes for comments and replies.

We also improved the experience after liking or commenting by keeping the user focused on the same page position.

For the visual design, we chose a **gyaru-inspired style** with pink as the main color because it matches our target audience.

We used soft pink and lavender backgrounds, pink-to-purple gradients, rounded cards, soft shadows, heart icons, and food emojis. The aim was to make the application feel cheerful, fashionable, and friendly while keeping the interface easy to understand.

---
ゆきさん
## 13:50–14:50 — How Lami-a Is Different From Other Applications

### What to Say

Lami-a has three main points of differentiation.

First, it is focused specifically on food rather than being a general-purpose social networking application.

Second, users can see the reviewer's food preferences. This helps them understand the background behind each rating.

Third, the evaluation categories are clear. Taste, portion size, cost performance, and visual appeal are separated, so users know exactly what was rated highly or poorly.

These three points make food recommendations more useful and personal than a photo and one overall rating alone.

---
ゆきさん
## 14:50–17:00 — Development Challenges and What We Learned

### What to Say

One of the biggest challenges was collaborative development.

Because several people worked on the same project, we sometimes created Git conflicts when our changes affected the same files. We also experienced errors caused by differences in software versions and operating systems.

Another challenge was that we started making major changes after the basic application was almost complete. As we added more custom features, the number of related errors increased.

A good example is the multiple-image post feature.

Originally, the application was designed to save only one image for each post. We wanted to support multiple images while keeping as much of the original controller as possible.

To do this, we continued saving the first image in the original posts table and saved the second and later images in a new post-images table.

However, this created a more complicated data structure. When we built the loops for saving and displaying the images, we encountered errors and had to consider two different image locations.

Through this experience, we learned the importance of agreeing on the final design and data structure before development begins. A clear final plan can reduce later changes, conflicts, and unnecessary complexity.

We also learned that when extending an existing feature, it is important to consider not only how to add new data, but also how the old and new structures will work together throughout the entire application.

---
らんさん
## 17:00–18:20 — Future Improvements

### What to Say

First, although users can already add location information, we would like to connect this feature to a map in the future. Users could view restaurants on a map and search by their current location or selected area.

Second, we would like to add a suggestion feature based on Taste Profiles. This could help users connect with people who have similar food preferences and discover more relevant posts.

Third, we would like to improve food discovery by allowing posts to be sorted and filtered by category. We would also like to add category-based rankings.

These improvements would make better use of the preference, rating, category, and location data that Lami-a already stores.

---
らんさん
## 18:20–18:50 — Conclusion

### What to Say

To summarize, Lami-a is an Instagram-style application focused on food.

It allows users to record and share meals, clearly evaluate the food experience, express their personal tastes, and connect with other users.

Its main strengths are its food-specific focus, visible reviewer preferences, clear rating categories, communication features, and target-focused pink design.

The development process also taught us the importance of planning the final structure before implementation and communicating carefully during collaborative development.

Thank you very much for listening. That concludes our presentation.
