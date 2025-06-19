<?php
require 'database.php';

$tarefas_abertas = $db->query("SELECT * FROM tarefas WHERE concluida = 0 ORDER BY vencimento ASC");
$tarefas_concluidas = $db->query("SELECT * FROM tarefas WHERE concluida = 1 ORDER BY vencimento DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --accent: #4895ef;
            --danger: #f72585;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
            --success: #4cc9f0;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        h1 {
            color: var(--primary);
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .add-task {
            background: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }
        
        .form-title {
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .form-title::before {
            content: "+";
            background: var(--primary);
            color: white;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }
        
        .task-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
        }
        
        @media (max-width: 600px) {
            .task-form {
                grid-template-columns: 1fr;
            }
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray);
        }
        
        input {
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        
        button {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
            font-size: 1rem;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: white;
            align-self: flex-end;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
        }
        
        .task-section {
            margin-bottom: 2rem;
        }
        
        .section-title {
            font-size: 1.25rem;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--primary);
        }
        
        .task-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        
        .task-card {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: transform 0.2s;
        }
        
        .task-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .task-info {
            flex: 1;
        }
        
        .task-desc {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }
        
        .task-date {
            color: var(--gray);
            font-size: 0.875rem;
        }
        
        .task-actions {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-success {
            background-color: var(--success);
            color: white;
        }
        
        .btn-success:hover {
            opacity: 0.9;
        }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        
        .btn-danger:hover {
            opacity: 0.9;
        }
        
        .completed {
            opacity: 0.7;
        }
        
        .completed .task-desc {
            text-decoration: line-through;
        }
        
        .empty-state {
            text-align: center;
            padding: 2rem;
            color: var(--gray);
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        
        .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciador de Tarefas</h1>
            <p>Organize suas tarefas de forma simples e eficiente</p>
        </header>
        
        <section class="add-task">
            <h2 class="form-title">Adicionar Nova Tarefa</h2>
            <form action="add_tarefa.php" method="post" class="task-form" id="taskForm">
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <input type="text" id="descricao" name="descricao" required>
                </div>
                <div class="form-group">
                    <label for="vencimento">Data de Vencimento</label>
                    <input type="date" id="vencimento" name="vencimento" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn-primary">Adicionar</button>
                </div>
            </form>
        </section>
        
        <section class="task-section">
            <h2 class="section-title">Tarefas Pendentes</h2>
            <div class="task-list">
                <?php if ($tarefas_abertas->fetchArray() === false): ?>
                    <div class="empty-state">
                        <div class="empty-icon">🎉</div>
                        <h3>Nenhuma tarefa pendente</h3>
                        <p>Adicione uma nova tarefa para começar</p>
                    </div>
                <?php else: ?>
                    <?php $tarefas_abertas->reset(); ?>
                    <?php while ($tarefa = $tarefas_abertas->fetchArray(SQLITE3_ASSOC)): ?>
                        <div class="task-card">
                            <div class="task-info">
                                <div class="task-desc"><?= htmlspecialchars($tarefa['descricao']) ?></div>
                                <div class="task-date">Vence em: <?= htmlspecialchars($tarefa['vencimento']) ?></div>
                            </div>
                            <div class="task-actions">
                                <form action="update_tarefa.php" method="post">
                                    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                    <button type="submit" class="btn-success">Concluir</button>
                                </form>
                                <form action="delete_tarefa.php" method="post" class="delete-form">
                                    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                    <button type="submit" class="btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </section>
        
        <section class="task-section">
            <h2 class="section-title">Tarefas Concluídas</h2>
            <div class="task-list">
                <?php if ($tarefas_concluidas->fetchArray() === false): ?>
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>Nenhuma tarefa concluída</h3>
                        <p>Complete algumas tarefas para vê-las aqui</p>
                    </div>
                <?php else: ?>
                    <?php $tarefas_concluidas->reset(); ?>
                    <?php while ($tarefa = $tarefas_concluidas->fetchArray(SQLITE3_ASSOC)): ?>
                        <div class="task-card completed">
                            <div class="task-info">
                                <div class="task-desc"><?= htmlspecialchars($tarefa['descricao']) ?></div>
                                <div class="task-date">Concluída | Vencia em: <?= htmlspecialchars($tarefa['vencimento']) ?></div>
                            </div>
                            <div class="task-actions">
                                <form action="delete_tarefa.php" method="post" class="delete-form">
                                    <input type="hidden" name="id" value="<?= $tarefa['id'] ?>">
                                    <button type="submit" class="btn-danger">Excluir</button>
                                </form>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <script>
        document.getElementById('taskForm').addEventListener('submit', function(e) {
            const descricao = document.getElementById('descricao').value.trim();
            const vencimento = document.getElementById('vencimento').value;
            
            if (!descricao) {
                alert('Por favor, insira uma descrição para a tarefa!');
                e.preventDefault();
                return;
            }
            
            if (!vencimento) {
                alert('Por favor, selecione uma data de vencimento!');
                e.preventDefault();
                return;
            }
            
            const today = new Date().toISOString().split('T')[0];
            if (vencimento < today) {
                if (!confirm('A data de vencimento é anterior a hoje. Deseja continuar?')) {
                    e.preventDefault();
                }
            }
        });
        
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Tem certeza que deseja excluir esta tarefa?')) {
                    e.preventDefault();
                }
            });
        });
        
        const taskCards = document.querySelectorAll('.task-card:not(.completed)');
        taskCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.boxShadow = '0 2px 4px rgba(0, 0, 0, 0.05)';
            });
        });
    </script>
</body>
</html>

<?php
$db->close();
?>