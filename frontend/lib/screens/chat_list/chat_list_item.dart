import 'package:flutter/material.dart';
import 'package:frontend/models/models.dart';
import 'package:frontend/utils/utils.dart';

class ChatListItem extends StatelessWidget {
  const ChatListItem({
    super.key,
    required this.item,
    required this.currentUser,
    required this.onPressed,
  });

  final ChatEntity item;
  final UserEntity currentUser;
  final void Function(ChatEntity) onPressed;

  @override
  Widget build(BuildContext context) {
    return ListTile(
      leading: const Icon(Icons.account_circle, size: 50.0),
      title: Text(
        item.name ??
            getChatName(
              item.participants,
              currentUser,
            ),
      ),
      subtitle: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Expanded(
            child: Text(
              item.lastMessage?.message ?? "...",
              overflow: TextOverflow.ellipsis,
              maxLines: 1,
            ),
          ),
          Text(utcToLocal(item.updatedAt)),
        ],
      ),
      onTap: () => onPressed(item),
    );
  }
}
