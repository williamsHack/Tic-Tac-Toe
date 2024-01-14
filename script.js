document.addEventListener('DOMContentLoaded', () => {
  const boardElement = document.getElementById('board');
  const restartBtn = document.getElementById('restart');
  const twoPlayersBtn = document.getElementById('twoPlayersMode');
  const vsAIBtn = document.getElementById('vsAIMode');
  const backgroundMusic = document.getElementById('backgroundMusic');
  const clickSound = document.getElementById('clickSound');
  const winSound = document.getElementById('winSound');
  const drawSound = document.getElementById('drawSound');
  const scoresElement = document.getElementById('scores');
  const playerScoreElement = document.getElementById('playerScore');
  const aiScoreElement = document.getElementById('aiScore');
  const tieScoreElement = document.getElementById('tieScore');

  let currentPlayer = 'O';
  let gameMode = 'twoPlayers';
  let isGameOver = false;
  let playerScore = 0;
  let aiScore = 0;
  let tieScore = 0;

  const board = ['', '', '', '', '', '', '', '', ''];

  const checkWinner = () => {
      const winPatterns = [
          [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
          [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
          [0, 4, 8], [2, 4, 6]              // Diagonals
      ];

      for (const pattern of winPatterns) {
          const [a, b, c] = pattern;
          if (board[a] && board[a] === board[b] && board[a] === board[c]) {
              return board[a];
          }
      }

      return null;
  };

  const checkDraw = () => {
      return !board.includes('');
  };

  const handleClick = (index) => {
      if (!board[index] && !isGameOver) {
          board[index] = currentPlayer;
          renderBoard();
          const winner = checkWinner();
          const draw = checkDraw();
          if (winner) {
              handleWin(winner);
          } else if (draw) {
              handleDraw();
          } else {
              currentPlayer = currentPlayer === 'O' ? 'X' : 'O';
              clickSound.play();
              if (gameMode === 'vsAI' && currentPlayer === 'X') {
                  setTimeout(makeAIMove, 500);
              }
          }
      }
  };

  const handleWin = (winner) => {
      showResult(`${winner} wins!`);
      if (winner === 'O') {
          playerScore++;
      } else {
          aiScore++;
      }
      updateScores();
  };

  const handleDraw = () => {
      showResult('It\'s a draw!');
      tieScore++;
      updateScores();
  };

  const updateScores = () => {
      playerScoreElement.textContent = playerScore;
      aiScoreElement.textContent = aiScore;
      tieScoreElement.textContent = tieScore;
  };

  const makeAIMove = () => {
      const emptyIndexes = board.reduce((acc, val, index) => (val === '' ? [...acc, index] : acc), []);
      const randomIndex = emptyIndexes[Math.floor(Math.random() * emptyIndexes.length)];
      handleClick(randomIndex);
  };

  const showResult = (message) => {
      document.getElementById('heading').innerText = message;
      isGameOver = true;
  };

  const restartGame = () => {
      board.fill('');
      currentPlayer = 'O';
      isGameOver = false;
      renderBoard();
      document.getElementById('heading').innerText = 'Play';
      if (gameMode === 'vsAI' && currentPlayer === 'X') {
          // If starting with AI, make AI move after a short delay
          setTimeout(makeAIMove, 500);
      }
  };

  const renderBoard = () => {
      boardElement.innerHTML = '';
      board.forEach((value, index) => {
          const box = document.createElement('div');
          box.classList.add('box');
          box.textContent = value;
          box.addEventListener('click', () => handleClick(index));
          boardElement.appendChild(box);
      });
  };

  restartBtn.addEventListener('click', restartGame);
  twoPlayersBtn.addEventListener('click', () => switchGameMode('twoPlayers'));
  vsAIBtn.addEventListener('click', () => switchGameMode('vsAI'));

  const switchGameMode = (mode) => {
      gameMode = mode;
      restartGame();
  };

  // Play background music when the page loads
  backgroundMusic.play();

  renderBoard();
});
